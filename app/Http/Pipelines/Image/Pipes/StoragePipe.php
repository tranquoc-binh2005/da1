<?php
namespace App\Http\Pipelines\Image\Pipes;

class StoragePipe extends AbstractPipe
{
    public function handle($image)
    {
        $uploadDir = $this->options['path'] ?? 'public/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filePath = rtrim($uploadDir, '/') . '/' . $image->filename;
        file_put_contents($filePath, $image->optimized);

        $image->path = $filePath;

        return $image;
    }
}
