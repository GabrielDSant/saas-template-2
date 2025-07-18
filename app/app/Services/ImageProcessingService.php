<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\GeneratedImage;
use Illuminate\Support\Facades\Log;

class ImageProcessingService
{
    /**
     * Processa a imagem original e aplica o estilo desejado.
     *
     * @param GeneratedImage $generatedImage
     * @return string Caminho da imagem gerada
     * @throws \Exception
     */
    public function process(GeneratedImage $generatedImage): string
    {
        try {
            $originalImagePath = $generatedImage->original_image_path;
            if (!$originalImagePath) {
                throw new \Exception('Caminho da imagem original não definido.');
            }
            $tempOriginal = tempnam(sys_get_temp_dir(), 'img_');
            $originalContent = Storage::disk('s3')->get($originalImagePath);
            file_put_contents($tempOriginal, $originalContent);

            $pngImagePath = $this->convertToPng($tempOriginal);
            $prompt = "Transforme esta imagem com o seguinte estilo: {$generatedImage->style}.";
            $imageContent = $this->callChatGPTAPI($pngImagePath, $prompt);

            $generatedImagePath = 'generated/' . uniqid() . '.png';
            Storage::disk('s3')->put($generatedImagePath, $imageContent, 'public');

            @unlink($tempOriginal);
            if ($pngImagePath !== $tempOriginal) {
                @unlink($pngImagePath);
            }

            return $generatedImagePath;
        } catch (\Exception $e) {
            Log::error('Erro ao processar imagem', [
                'generated_image_id' => $generatedImage->id ?? null,
                'original_image_path' => $generatedImage->original_image_path ?? null,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    private function convertToPng($filePath)
    {
        // Simulação: apenas retorna o mesmo arquivo
        return $filePath;
    }

    private function callChatGPTAPI($imagePath, $prompt)
    {
        $apiKey = env('OPENAI_API_KEY');
        $client = new Client();

        $response = $client->post('https://api.openai.com/v1/images/edits', [
            'headers' => [
                'Authorization' => "Bearer {$apiKey}",
            ],
            'multipart' => [
                [
                    'name' => 'model',
                    'contents' => 'dall-e-3',
                ],
                [
                    'name' => 'image[]',
                    'contents' => fopen(storage_path('app/public/' . $imagePath), 'r'),
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
