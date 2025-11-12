<?php

declare(strict_types=1);

namespace App\Routing;

use App\View\View;

class Router
{
    /** @var array<string, callable> */
    private array $routes = [];

    public function get(string $path, callable $action): void
    {
        $this->routes['GET' . $this->normalize($path)] = $action;
    }

    public function dispatch(string $method, string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $key = $method . $this->normalize($path);

        $action = $this->routes[$key] ?? null;

        if ($action === null) {
            http_response_code(404);
            return view('errors.404')->render();
        }

        $response = $action();

        if ($response instanceof View) {
            return $response->render();
        }

        return (string) $response;
    }

    private function normalize(string $path): string
    {
        return rtrim($path, '/') ?: '/';
    }
}
