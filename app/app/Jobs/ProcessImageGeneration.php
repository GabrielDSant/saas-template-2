<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\GeneratedImage;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ImageProcessingService;
use Illuminate\Support\Facades\Log;

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
            $service = new ImageProcessingService();
            $generatedImagePath = $service->process($this->generatedImage);
            $this->generatedImage->update([
                'generated_image_path' => $generatedImagePath,
                'status' => 'completed',
                'error_message' => null,
            ]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            Log::error('Erro no job ProcessImageGeneration', [
                'generated_image_id' => $this->generatedImage->id,
                'error' => $errorMessage,
            ]);
            $this->generatedImage->update([
                'status' => 'failed',
                'error_message' => $errorMessage,
            ]);
        }
    }
}
