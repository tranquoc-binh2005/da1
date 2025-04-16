<?php
namespace App\Http\Pipelines\Image\Pipes;

class OptimizeImagePipe extends AbstractPipe
{
    public function handle($image)
    {
        $tmpPath = $image->originalFile['tmp_name'];

        if (!file_exists($tmpPath)) {
            throw new \Exception("File không tồn tại tại đường dẫn: $tmpPath");
        }

        $quality = $this->options['quality'] ?? 80;

        $imageContent = file_get_contents($tmpPath);
        $imageResource = imagecreatefromstring($imageContent);

        if (!$imageResource) {
            throw new \Exception("Không thể tạo ảnh từ dữ liệu file.");
        }

        ob_start();
        imagejpeg($imageResource, null, $quality);
        $optimizedContent = ob_get_clean();

        $image->optimized = $optimizedContent;

        return $image;
    }
}
