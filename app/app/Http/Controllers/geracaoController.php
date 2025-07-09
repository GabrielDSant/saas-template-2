<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessImageGeneration;
use App\Models\Estilos;
use App\Models\GeneratedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class geracaoController extends Controller
{

    public function gerarImagem(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:png,jpg,svg,webp,gif|max:2048',
                'styles' => 'required|string',
            ]);

            // Salve a imagem original em um diretório persistente no disco 's3'
            $originalImage = $request->file('image');
            $originalImageName = uniqid('original_') . '.' . $originalImage->getClientOriginalExtension();
            $originalImagePath = $originalImage->storeAs('originals', $originalImageName, 's3'); // <-- disco 's3'

            $styles = explode(',', $request->input('styles'));
            $user = $request->user();

            foreach ($styles as $styleName) {
                $generatedImage = GeneratedImage::create([
                    'user_id' => $user->id,
                    'original_image_path' => $originalImagePath,
                    'style' => $styleName,
                ]);

                ProcessImageGeneration::dispatch($generatedImage);
            }

            return redirect()->back()->with('success', 'Imagens enviadas para processamento!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao processar a imagem: ' . $e->getMessage()]);
        }
    }

    private function processImageWithChatGPT($imagePath, $prompt, $user)
    {
        // Simulação de integração com ChatGPT
        $fullPrompt = "Transforme esta imagem com o seguinte estilo: {$prompt}.";
        // Aqui você integraria com a API do ChatGPT e obteria o conteúdo da imagem gerada
        $generatedImageContent = 'conteúdo binário da imagem gerada'; // Simulação do conteúdo gerado
        return $generatedImageContent;
    }

    private function saveGeneratedImage($path, $content)
    {
        if (!Storage::exists('public/generated')) {
            Storage::makeDirectory('public/generated');
        }
        Storage::put('public/' . $path, $content);
    }
}
