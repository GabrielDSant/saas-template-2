<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessImageGeneration;
use App\Models\Estilos;
use App\Models\GeneratedImage;
use App\Http\Requests\GerarImagemRequest;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageProcessingService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;
class geracaoController extends Controller
{
    public function gerarImagem(GerarImagemRequest $request)
    {
        try {
            $originalImage = $request->file('image');
            $originalImageName = uniqid('original_') . '.' . $originalImage->getClientOriginalExtension();
            $originalImagePath = $originalImage->storeAs('originals', $originalImageName, 's3');

            $styles = explode(',', $request->input('styles'));
            $user = $request->user();

            foreach ($styles as $styleName) {
                $generatedImage = GeneratedImage::create([
                    'user_id' => $user->id,
                    'original_image_path' => $originalImagePath,
                    'style' => $styleName,
                    'status' => 'pending',
                ]);

                ProcessImageGeneration::dispatch($generatedImage);
            }

            return redirect()->back()->with('success', 'Imagens enviadas para processamento!');
        } catch (\Exception $e) {
            Log::error('Erro ao processar upload de imagem', [
                'user_id' => $request->user()->id ?? null,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->withErrors(['error' => 'Erro ao processar a imagem: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $generatedImage = GeneratedImage::findOrFail($id);
        $this->authorize('view', $generatedImage);
        return view('pages.cliente.imagem', compact('generatedImage'));
    }

    public function destroy($id)
    {
        $generatedImage = GeneratedImage::findOrFail($id);
        $this->authorize('delete', $generatedImage);
        $generatedImage->delete();
        return redirect()->route('dashboard.geracoes')->with('success', 'Imagem excluída com sucesso!');
    }
}
