<?php

namespace App\Http\Controllers;

use App\Models\Estilos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class geracaoController extends Controller
{

    public function gerarImagem(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,svg,webp,gif|max:2048',
            'styles' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');
        $styles = explode(',', $request->input('styles'));
        $user = $request->user();

        $generatedImages = [];
        foreach ($styles as $styleName) {
            $style = Estilos::where('name', $styleName)->first();
            if ($style) {
                $generatedImagePath = $this->processImageWithChatGPT($imagePath, $style->prompt, $user);
                $this->saveGeneratedImage($generatedImagePath);
                $generatedImages[] = $generatedImagePath;
            }
        }

        return redirect()->back()->with('success', 'Imagens geradas com sucesso!');
    }

    private function processImageWithChatGPT($imagePath, $prompt, $user)
    {
        // Simulação de integração com ChatGPT
        $fullPrompt = "Transforme esta imagem com o seguinte estilo: {$prompt}.";
        // Aqui você integraria com a API do ChatGPT
        return 'generated/' . uniqid() . '_' . basename($imagePath); // Simulação
    }

    private function saveGeneratedImage($path)
    {
        if (!Storage::exists('public/generated')) {
            Storage::makeDirectory('public/generated');
        }
        Storage::put('public/' . $path, 'conteúdo da imagem gerada');
    }
}
