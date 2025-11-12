<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\PayrollCalculator;

class PayrollController
{
    public function __construct(private PayrollCalculator $calculator = new PayrollCalculator())
    {
    }

    public function index()
    {
        $employee = Employee::sample();
        $result = $this->calculator->calculate($employee);

        return view('payroll/index', [
            'employee' => $employee,
            'result' => $result,
            'breadcrumbs' => ['خانه', 'فیش حقوقی نمونه'],
        ]);
    }
}
