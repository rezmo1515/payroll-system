<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$router = require __DIR__ . '/../bootstrap/app.php';

echo $router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
