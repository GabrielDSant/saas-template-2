<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class geracaoController extends Controller
{
    public function gerarImagem(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,svg,webp,gif|max:2048',
            'style' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');
        $style = $request->input('style');

        // Simulação de envio ao ChatGPT e retorno da imagem gerada
        $generatedImagePath = $this->processImageWithChatGPT($imagePath, $style);

        // Salvar a imagem gerada no banco de dados (simulação)
        $this->saveGeneratedImage($generatedImagePath);

        return redirect()->back()->with('success', 'Imagem gerada com sucesso!');
    }

    private function processImageWithChatGPT($imagePath, $style)
    {
        // Simulação de integração com ChatGPT
        $prompt = match ($style) {
            'perfil_profissional' => 'Transforme esta imagem em uma imagem de perfil profissional.',
            'estilo_pintura' => 'Transforme esta imagem em um estilo de pintura.',
            'estilo_cartoon' => 'Transforme esta imagem em um estilo cartoon.',
            default => 'Transforme esta imagem.',
        };

        // Aqui você integraria com a API do ChatGPT e retornaria o caminho da imagem gerada
        return 'generated/' . basename($imagePath); // Simulação
    }

    private function saveGeneratedImage($path)
    {
        // Simulação de salvar no banco de dados
        // Exemplo: GeneratedImage::create(['path' => $path]);

        // Certifique-se de criar o diretório "generated" se ele não existir
        if (!Storage::exists('public/generated')) {
            Storage::makeDirectory('public/generated');
        }

        // Simulação de salvar a imagem gerada
        Storage::put('public/' . $path, 'conteúdo da imagem gerada');
    }
}
