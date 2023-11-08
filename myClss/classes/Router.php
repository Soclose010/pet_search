<?php

namespace myClss;

use myClss\Middlewares\Auth;
use myClss\Middlewares\Guest;

class Router
{
    private array $routes = [];
    private string $uri;
    private string $method;

    private array $middlewares = [
        'auth' => Auth::class,
        'guest' => Guest::class
    ];

    public function __construct()
    {
        $this->uri = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        $this->method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    }

    public function middleware(string $middleware): void
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;
    }

    private function add(string $uri, string $controller, string $method): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null,
        ];
    }

    public function match(): void
    {
        $matches = false;
        foreach ($this->routes as $route) {
            if ($route['uri'] === $this->uri && $route['method'] === strtoupper($this->method)) {
                $matches = true;

                if (array_key_exists($route['middleware'],$this->middlewares))
                {
                    (new $this->middlewares[$route['middleware']])->handle();
                }
                require_once CONTROLLERS . "/{$route['controller']}";
                break;
            }
        }
        if (!$matches)
            abort();
    }

    public function get(string $uri, string $controller): static
    {
        $this->add($uri, $controller, 'GET');
        return $this;
    }

    public function post(string $uri, string $controller): static
    {
        $this->add($uri, $controller, 'POST');
        return $this;
    }

    public function put(string $uri, string $controller): static
    {
        $this->add($uri, $controller, 'PUT');
        return $this;
    }

    public function delete(string $uri, string $controller): static
    {
        $this->add($uri, $controller, 'DELETE');
        return $this;
    }
}