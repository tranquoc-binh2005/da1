<?php
namespace App\Http\Pipelines\Image\Pipes;

class GenerateFileNamePipe extends AbstractPipe
{
    public function handle($image)
    {
        $originalFile = $image->originalFile;

        if (!isset($originalFile['name'])) {
            throw new \Exception('File ảnh không hợp lệ: thiếu tên file.');
        }

        $extension = pathinfo($originalFile['name'], PATHINFO_EXTENSION);
        $filename = uniqid('img_') . '.' . $extension;

        $image->filename = $filename;

        return $image;
    }
}
