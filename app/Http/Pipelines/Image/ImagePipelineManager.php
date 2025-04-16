<?php
namespace App\Http\Pipelines\Image;

use App\Http\Pipelines\Image\Pipes\GenerateFileNamePipe;
use App\Http\Pipelines\Image\Pipes\OptimizeImagePipe;
use App\Http\Pipelines\Image\Pipes\StoragePipe;
class ImagePipelineManager
{
    protected array $defaultPipeline = [];

    public function __construct()
    {
        $this->defaultPipeline = [
            'generate_filename' => GenerateFileNamePipe::class,
            'optimize' => OptimizeImagePipe::class,
            'storage' => StoragePipe::class,
        ];
    }

    public function process($image, string $pipelineKey = '', array $overrideOptions = []): object
    {
        $config = include __DIR__ . '/../../../../config/upload.php';
        $pipelineConfig = $config[$pipelineKey] ?? [];

        foreach ($pipelineConfig as $pipeName => $pipeOptions) {
            if (!($pipeOptions['enabled'] ?? true)) continue;

            $pipeClass = $this->defaultPipeline[$pipeName] ?? null;
            if (!$pipeClass || !class_exists($pipeClass)) continue;

            $options = array_merge($pipeOptions, $overrideOptions[$pipeName] ?? []);
            $pipe = new $pipeClass($options);
            $image = $pipe->handle($image);
        }

        return $image;
    }
}
