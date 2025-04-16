<?php

namespace App\Http\Request;
use App\Http\Repositories\BaseRepository;
use App\Models\Database;

class FormRequest
{
    private array $query;    // $_GET
    private array $request;  // $_POST
    private $files;    // $_FILES
    private $headers;  // Headers
    private mixed $method;   // FormRequest method
    private mixed $uri;      // FormRequest URI

    protected \PDO $database;
    protected BaseRepository $baseRepository;

    public function __construct()
    {
        $this->query = $_GET;
        $this->request = $_POST;
        $this->files = $_FILES;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->headers = getallheaders();

        $this->database = Database::connection();
        $this->baseRepository = new BaseRepository($this->database);
    }

    public static function capture(): static
    {
        return new static();
    }

    public function all(): array
    {
        return array_merge($this->query, $this->request);
    }

    public function input(string $key, $default = null)
    {
        return $this->all()[$key] ?? $default;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function file(string $key)
    {
        return $this->files[$key] ?? null;
    }

    public function header(string $key, $default = null)
    {
        return $this->headers[$key] ?? $default;
    }

    public function only(array $keys): array
    {
        $data = $this->all();
        return array_intersect_key($data, array_flip($keys));
    }

    public function except(array $keys): array
    {
        $data = $this->all();
        return array_diff_key($data, array_flip($keys));
    }
}