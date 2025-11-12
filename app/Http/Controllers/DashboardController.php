<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\ModuleCatalogue;

class DashboardController
{
    public function __construct(private ModuleCatalogue $catalogue = new ModuleCatalogue())
    {
    }

    public function index()
    {
        return view('dashboard', [
            'modules' => $this->catalogue->featured(),
            'breadcrumbs' => ['خانه'],
        ]);
    }

    public function modules()
    {
        return view('modules/index', [
            'modules' => $this->catalogue->all(),
            'breadcrumbs' => ['خانه', 'لیست ماژول‌ها'],
        ]);
    }
}
