<?php

declare(strict_types=1);

use App\Routing\Router;

$router = new Router();

(require __DIR__ . '/../routes/web.php')($router);

return $router;
