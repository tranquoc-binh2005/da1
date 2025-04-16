<?php
namespace App\Http\Services\Impl\Upload;

use App\Http\Pipelines\Image\ImagePipelineManager;
use App\Http\Services\Interfaces\Upload\ImageServiceInterface;

class ImageService implements ImageServiceInterface
{
    private $config;
    protected array $uploadedFiles = [];
    protected array $errors = [];
    protected ImagePipelineManager $imageManager;


    public function __construct()
    {
        $this->imageManager = new ImagePipelineManager();
        $this->config = require_once __DIR__ . "/../../../../../config/upload.php";
    }

    private function normalizeFiles(array $files): array
    {
        $normalized = [];

        if (isset($files['name']) && is_array($files['name'])) {
            $fileCount = count($files['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                $normalized[] = [
                    'name'     => $files['name'][$i],
                    'type'     => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error'    => $files['error'][$i],
                    'size'     => $files['size'][$i],
                ];
            }
        } else {
            $normalized[] = $files;
        }

        return $normalized;
    }


    public function upload($files, $pipelineKey, $overrideOptions)
    {
        try {
            $files = $this->normalizeFiles($files);
            if($files){
                $this->uploadedFiles = [];
                $this->errors = [];
                if(count($files)){
                    return $this->multipleUpload($files, $pipelineKey, $overrideOptions);
                }
                return $this->singleUpload($files, $pipelineKey , $overrideOptions);
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function singleUpload($file, $pipelineKey = 'default', array $overrideOptions = []): array
    {
        try {
            $result = $this->handleUpload($file, $pipelineKey, $overrideOptions);
            $this->uploadedFiles = [$result];
        } catch (\Exception $e) {
            $this->errors[] = [
                'file' => $file['name'],
                'error' => $e->getMessage()
            ];
        }
        return $this->generateResponse();
    }

    private function multipleUpload($files, $pipelineKey, $overrideOptions): array
    {
        $this->uploadedFiles = [];
        $this->errors = [];

        foreach ($files as $file) {
            try {
                $result = $this->handleUpload($file, $pipelineKey, $overrideOptions);
                $this->uploadedFiles[] = $result;
            } catch (\Exception $e) {
                $this->errors[] = [
                    'file' => $file['name'],
                    'error' => $e->getMessage()
                ];
            }
        }

        return $this->generateResponse();
    }

    private function handleUpload($file, $pipelineKey, $overrideOptions): array
    {
        try {
            $image = new \stdClass();

            if (!isset($file['tmp_name']) && !is_array($file)) {
                throw new \Exception('Dữ liệu ảnh không hợp lệ.');
            }
            $image->originalFile = $file;

            $result = $this->imageManager->process($image, $pipelineKey, $overrideOptions);

            return [
                'path' => $result->path
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function generateResponse(): array
    {
        $response = [
            'success' => count($this->errors) === 0,
            'files' => $this->uploadedFiles,
            'total_uploaded' => count($this->uploadedFiles)
        ];

        if (!empty($this->errors)) {
            $response['error'] = $this->errors;
        }

        return $response;
    }
}