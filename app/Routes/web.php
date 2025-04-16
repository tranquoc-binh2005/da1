<?php
namespace App\Routes;

use App\Providers\ServiceProvider;
use ReflectionClass;

class web
{
    private array $routes = [];
    private string $basePath;
    private array $middlewares = [];
    private string $controllerNamespace = "";
    private string $lastRouteMethod;
    private string $lastRoutePattern;

    public function __construct()
    {
        $this->basePath = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
    }

    public function get(string $path, $handler): self
    {
        return $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, $handler): self
    {
        return $this->addRoute('POST', $path, $handler);
    }

    public function group(array $attributes, callable $callback): void
    {
        $previousMiddlewares = $this->middlewares;
        if (isset($attributes['middleware'])) {
            $this->middlewares = array_merge($this->middlewares, (array)$attributes['middleware']);
        }

        $callback($this);

        $this->middlewares = $previousMiddlewares;
    }

    private function addRoute(string $method, string $path, $handler): self
    {
        $path = trim($path, '/');
        $pattern = "#^" . preg_replace('#\\{([a-zA-Z0-9_]+)\\}#', '([^/]+)', $path) . "$#";

        $this->routes[$method][$pattern] = [
            'handler' => $handler,
            'middlewares' => $this->middlewares
        ];

        $this->lastRouteMethod = $method;
        $this->lastRoutePattern = $pattern;

        return $this;
    }

    public function middleware(array $middlewares): self
    {
        if (isset($this->routes[$this->lastRouteMethod][$this->lastRoutePattern])) {
            $this->routes[$this->lastRouteMethod][$this->lastRoutePattern]['middlewares'] = array_merge(
                $this->routes[$this->lastRouteMethod][$this->lastRoutePattern]['middlewares'],
                $middlewares
            );
        }

        return $this;
    }


    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = trim(str_replace($this->basePath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');
        $this->dispatch($method, $uri);
    }

    private function dispatch(string $method, string $uri): void
    {
        foreach ($this->routes[$method] ?? [] as $pattern => $route) {
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                foreach ($route['middlewares'] as $middleware) {
                    $middlewareClass = "App\\Http\\Middleware\\" . $middleware;
                    if (class_exists($middlewareClass)) {
                        $middlewareInstance = new $middlewareClass();
                        if (method_exists($middlewareInstance, 'handle')) {
                            $middlewareInstance->handle();
                        }
                    }
                }
                $this->handleHandler($route['handler'], $matches);
                return;
            }
        }

        $this->sendResponse(404, 'Route not found');
    }

    private function handleHandler($handler, array $params): void
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_string($handler) && str_contains($handler, '@')) {
            [$controller, $method] = explode('@', $handler);

            if (class_exists($controller)) {
                try {
                    $reflection = new ReflectionClass($controller);
                    $constructor = $reflection->getConstructor();
                    $dependencies = [];
                    if ($constructor) {
                        foreach ($constructor->getParameters() as $param) {
                            $paramType = $param->getType();
                            if ($paramType && !$paramType->isBuiltin()) {
                                $dependencyClass = $paramType->getName();

                                if (interface_exists($dependencyClass)) {
                                    $dependencies[] = ServiceProvider::resolve($dependencyClass);
                                } else {
                                    $dependencies[] = new $dependencyClass();
                                }
                            }
                        }
                    }

                    $controllerInstance = $reflection->newInstanceArgs($dependencies);

                    if (method_exists($controllerInstance, $method)) {
                        call_user_func_array([$controllerInstance, $method], $params);
                        return;
                    }
                } catch (\Exception $e) {
                    $this->sendResponse(500, "Lỗi Dependency Injection: " . $e->getMessage());
                    return;
                }
            }
        }

        $this->sendResponse(500, 'Invalid handler');
    }

    private function sendResponse(int $code, string $message): void
    {
        http_response_code($code);
        echo $message;
    }
}