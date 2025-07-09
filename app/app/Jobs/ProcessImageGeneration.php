<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\GeneratedImage;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;


class ProcessImageGeneration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $generatedImage;

    public function __construct(GeneratedImage $generatedImage)
    {
        $this->generatedImage = $generatedImage;
    }

    public function handle()
    {
        $this->generatedImage->update(['status' => 'processing']);

        try {
            // Caminho relativo da imagem original no S3
            $originalImagePath = $this->generatedImage->original_image_path;
            // Baixar a imagem do S3 para um arquivo temporário local
            $tempOriginal = tempnam(sys_get_temp_dir(), 'img_');
            $originalContent = Storage::disk('s3')->get($originalImagePath);
            file_put_contents($tempOriginal, $originalContent);

            // Converta a imagem para PNG se necessário
            $pngImagePath = $this->convertToPng($tempOriginal);

            // Simulação de integração com a API do ChatGPT
            $prompt = "Transforme esta imagem com o seguinte estilo: {$this->generatedImage->style}.";
            $imageContent = $this->callChatGPTAPI($pngImagePath, $prompt);

            $generatedImagePath = 'generated/' . uniqid() . '.png';
            Storage::disk('s3')->put($generatedImagePath, $imageContent, 'public');

            $this->generatedImage->update([
                'generated_image_path' => $generatedImagePath,
                'status' => 'completed',
            ]);

            // Limpar arquivos temporários
            @unlink($tempOriginal);
            if ($pngImagePath !== $tempOriginal) {
                @unlink($pngImagePath);
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            if (method_exists($e, 'getResponse') && $e->getResponse()) {
                $errorMessage .= ' | Response: ' . $e->getResponse()->getBody()->getContents();
            }
            $this->generatedImage->update([
                'status' => 'failed',
                'error_message' => $errorMessage,
            ]);
        }
    }

    /**
     * Converte a imagem para PNG se não estiver nesse formato.
     * Retorna o caminho absoluto do arquivo PNG.
     */
    private function convertToPng($imagePath)
    {
        $info = getimagesize($imagePath);
        $mime = $info['mime'];

        // Se já for PNG, retorna o próprio caminho
        if ($mime === 'image/png') {
            return $imagePath;
        }

        // Carrega a imagem conforme o tipo
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($imagePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($imagePath);
                break;
            case 'image/svg+xml':
                // SVG não é suportado nativamente pelo GD, pode ser necessário converter via ferramenta externa
                throw new \Exception('SVG não suportado para conversão automática.');
            default:
                throw new \Exception('Formato de imagem não suportado para conversão.');
        }

        // Novo caminho para o PNG convertido
        $pngPath = preg_replace('/\.\w+$/', '.png', $imagePath);

        // Salva como PNG
        imagepng($image, $pngPath);
        imagedestroy($image);

        return $pngPath;
    }

    private function callChatGPTAPI($imagePath, $prompt)
    {
        $apiKey = env('OPENAI_API_KEY');
        $client = new Client();

        $absoluteImagePath = $imagePath;

        // Validação se o arquivo existe
        if (!file_exists($absoluteImagePath)) {
            throw new \Exception("Arquivo de imagem não encontrado: {$absoluteImagePath}");
        }

        $response = $client->post('https://api.openai.com/v1/images/edits', [
            'headers' => [
                'Authorization' => "Bearer {$apiKey}",
            ],
            'multipart' => [
                [
                    'name' => 'model',
                    'contents' => 'gpt-image-1', // modelo correto para edits
                ],
                [
                    'name' => 'image[]',
                    'contents' => fopen($absoluteImagePath, 'r'),
                    'filename' => basename($absoluteImagePath),
                ],
                [
                    'name' => 'prompt',
                    'contents' => $prompt,
                ],
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);

        if (isset($responseBody['data'][0]['b64_json'])) {
            return base64_decode($responseBody['data'][0]['b64_json']);
        }

        throw new \Exception('Erro ao gerar imagem: resposta inválida da API.');
    }
}
