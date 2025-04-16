<?php
namespace App\Traits;

trait HasRender
{
    protected function view(string $view, array $data = []): self
    {
        try {
            extract($data);
            if(! $path = $this->handlePath("Views/dashboard/", $view)){
                die("View không tồn tại: " . $path);
            }
            require_once $path;
        } catch (\Exception $e){
            echo $e->getMessage();
        }
        return $this;
    }

    protected function render(string $view, array $data = []): self
    {
        try {
            extract($data);
            if(! $path = $this->handlePath("Views/", $view)){
                die("View không tồn tại: " . $path);
            }
            require_once $path;
        } catch (\Exception $e){
            echo $e->getMessage();
        }
        return $this;
    }

    protected function helper(string $view, array $data = []): self
    {
        try {
            extract($data);
            if(! $path = $this->handlePath("Views/helper/", $view)){
                die("View không tồn tại: " . $path);
            }
            require_once $path; die();
        } catch (\Exception $e){
            echo $e->getMessage();
        }
        return $this;
    }

    private function handlePath(string $folder = '',string $view = ''): string
    {
        $path = dirname(__DIR__, 3) . "/app/{$folder}" . $view . ".php";
        $nameProject = trim(basename(dirname(__DIR__, 3)));
        [$host, $path] = explode($nameProject . '/', $path);
        return $path;
    }
}