<?php

declare(strict_types=1);

use App\Support\Str;

if (! function_exists('asset')) {
    function asset(string $path): string
    {
        $path = ltrim($path, '/');
        return '/'.$path;
    }
}

if (! function_exists('view')) {
    function view(string $template, array $data = []): App\View\View
    {
        return new App\View\View($template, $data);
    }
}

if (! function_exists('config')) {
    function config(string $key, mixed $default = null): mixed
    {
        static $config = [];

        if ($config === []) {
            foreach (glob(__DIR__ . '/../../config/*.php') as $file) {
                $name = basename($file, '.php');
                $config[$name] = require $file;
            }
        }

        [$group, $item] = array_pad(explode('.', $key, 2), 2, null);

        if (! isset($config[$group])) {
            return $default;
        }

        if ($item === null) {
            return $config[$group];
        }

        return $config[$group][$item] ?? $default;
    }
}

if (! function_exists('str')) {
    function str(string $value = ''): Str
    {
        return new Str($value);
    }
}
