<?php

namespace myClss;

class Router
{
    private array $routes = [];
    private string $uri;
    private string $method;

    public function __construct()
    {
        $this->uri = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        $this->method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    }

    private function add(string $uri, string $controller, string $method): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
        ];
    }

    public function match(): void
    {
        $matches = false;
        foreach ($this->routes as $route) {
            if ($route['uri'] === $this->uri && $route['method'] === strtoupper($this->method)) {
                $matches = true;
                require_once CONTROLLERS . "/{$route['controller']}";
                break;
            }
        }
        if (!$matches)
            abort();
    }

    public function get(string $uri, string $controller): void
    {
        $this->add($uri, $controller, 'GET');
    }

    public function post(string $uri, string $controller): void
    {
        $this->add($uri, $controller, 'POST');
    }

    public function put(string $uri, string $controller): void
    {
        $this->add($uri, $controller, 'PUT');
    }

    public function delete(string $uri, string $controller): void
    {
        $this->add($uri, $controller, 'DELETE');
    }
}