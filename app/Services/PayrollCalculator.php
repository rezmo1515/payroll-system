<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Employee;
use App\Services\DTO\PayrollComponentResult;
use App\Services\DTO\PayrollResult;

class PayrollCalculator
{
    public function calculate(Employee $employee): PayrollResult
    {
        $allowances = [];
        foreach ($employee->allowances as $allowance) {
            $allowances[] = new PayrollComponentResult(
                name: $allowance['name'],
                code: $allowance['code'],
                amount: (int) round($this->evaluateFormula($allowance['formula'], $employee)),
            );
        }

        $deductions = [];
        foreach ($employee->deductions as $deduction) {
            $deductions[] = new PayrollComponentResult(
                name: $deduction['name'],
                code: $deduction['code'],
                amount: (int) round($this->evaluateFormula($deduction['formula'], $employee)),
            );
        }

        return new PayrollResult(
            baseSalary: $employee->baseSalary,
            allowances: $allowances,
            deductions: $deductions,
        );
    }

    private function evaluateFormula(string $formula, Employee $employee): float
    {
        $variables = [
            'base_salary' => $employee->baseSalary,
            'work_days' => $employee->workDays,
            'daily_rate' => $employee->baseSalary / max(1, config('payroll.working_days', 30)),
        ];

        $expression = preg_replace_callback('/\b([a-z_]+)\b/', function ($matches) use ($variables) {
            $key = $matches[1];
            if (array_key_exists($key, $variables)) {
                return (string) $variables[$key];
            }
            return $matches[0];
        }, $formula);

        $expression = (string) $expression;

        $allowed = '/[^0-9+\-*\/.() ]/';
        if (preg_match($allowed, $expression)) {
            throw new \InvalidArgumentException('Invalid characters in formula: ' . $formula);
        }

        set_error_handler(static function () {
            throw new \RuntimeException('Error while evaluating payroll formula.');
        });

        try {
            /** @var float $result */
            $result = eval('return ' . $expression . ';');
        } finally {
            restore_error_handler();
        }

        return (float) $result;
    }
}
