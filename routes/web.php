<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PayrollController;
use App\Routing\Router;

return static function (Router $router): void {
    $dashboard = new DashboardController();
    $payroll = new PayrollController();

    $router->get('/', [$dashboard, 'index']);
    $router->get('/modules', [$dashboard, 'modules']);
    $router->get('/payroll', [$payroll, 'index']);
};
