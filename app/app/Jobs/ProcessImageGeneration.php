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
            // Simulação de integração com a API do ChatGPT
            $prompt = "Transforme esta imagem com o seguinte estilo: {$this->generatedImage->style}.";
            $imageContent = $this->callChatGPTAPI($this->generatedImage->original_image_path, $prompt);

            $generatedImagePath = 'generated/' . uniqid() . '.png';
            Storage::put('public/' . $generatedImagePath, $imageContent);

            $this->generatedImage->update([
                'generated_image_path' => $generatedImagePath,
                'status' => 'completed',
            ]);
        } catch (\Exception $e) {
            // Captura a mensagem completa do erro
            $errorMessage = $e->getMessage();
        
            // Opcional: Se o erro for relacionado à resposta da API, capture o corpo da resposta
            if (method_exists($e, 'getResponse') && $e->getResponse()) {
                $errorMessage .= ' | Response: ' . $e->getResponse()->getBody()->getContents();
            }
        
            // Atualiza o status e salva o erro completo no banco
            $this->generatedImage->update([
                'status' => 'failed',
                'error_message' => $errorMessage,
            ]);
        }
    }

    private function callChatGPTAPI($imagePath, $prompt)
    {
        $apiKey = env('OPENAI_API_KEY');
        $client = new Client();

        // Corrija para buscar em storage/app/public/
        $absoluteImagePath = storage_path('app/public/' . $imagePath);

        $response = $client->post('https://api.openai.com/v1/images/edits', [
            'headers' => [
                'Authorization' => "Bearer {$apiKey}",
            ],
            'multipart' => [
                [
                    'name' => 'model',
                    'contents' => 'dall-e-2',
                ],
                [
                    'name' => 'image',
                    'contents' => fopen($absoluteImagePath, 'r'),
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
