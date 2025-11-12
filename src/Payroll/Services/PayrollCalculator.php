<?php

declare(strict_types=1);

namespace App\Payroll\Services;

use App\Payroll\DTO\PayrollComponentResult;
use App\Payroll\DTO\PayrollResult;
use App\Payroll\Employee;
use App\Payroll\Support\ExpressionEvaluator;

final class PayrollCalculator
{
    /** @var array<string, mixed> */
    private array $config;

    public function __construct(private readonly ExpressionEvaluator $evaluator, array $config)
    {
        $this->config = $config;
    }

    public static function fromConfigPath(string $path): self
    {
        /** @var array<string, mixed> $config */
        $config = require $path;
        return new self(new ExpressionEvaluator(), $config);
    }

    public function calculate(Employee $employee, array $overrides = []): PayrollResult
    {
        $settings = $this->config['settings'] ?? [];
        $components = $this->config['components'] ?? [];

        $context = array_merge($this->buildBaseContext($employee, $settings), $overrides);

        $results = [];
        $earningTotal = 0.0;
        $deductionTotal = 0.0;

        foreach ($components as $key => $definition) {
            $amount = $this->resolveAmount($definition, $context);
            $type = $definition['type'] ?? 'earning';
            $title = $definition['title'] ?? $key;
            $category = $definition['category'] ?? ($type === 'deduction' ? 'کسورات' : 'مزایا');
            $description = $definition['description'] ?? '';

            if ($type === 'earning') {
                $earningTotal += $amount;
            } else {
                $deductionTotal += $amount;
            }

            $results[] = new PayrollComponentResult(
                key: (string) $key,
                title: (string) $title,
                category: (string) $category,
                type: (string) $type,
                amount: $amount,
                description: (string) $description
            );
        }

        $netPay = max(0.0, $earningTotal - $deductionTotal);

        return new PayrollResult($results, $earningTotal, $deductionTotal, $netPay);
    }

    /**
     * @param array<string, mixed> $definition
     * @param array<string, float|int|bool> $context
     */
    private function resolveAmount(array $definition, array $context): float
    {
        $expression = (string) ($definition['expression'] ?? '0');
        $rawAmount = $this->evaluator->evaluate($expression, $context);
        $precision = (int) ($definition['precision'] ?? ($this->config['precision'] ?? 0));

        return round($rawAmount, $precision);
    }

    /**
     * @param array<string, float|int|bool> $settings
     * @return array<string, float|int|bool>
     */
    private function buildBaseContext(Employee $employee, array $settings): array
    {
        $standardDays = (float) ($settings['standard_days'] ?? 30);
        $hoursPerDay = (float) ($settings['hours_per_day'] ?? 7.33);
        $overtimeRate = (float) ($settings['overtime_rate'] ?? 1.4);
        $nightShiftRate = (float) ($settings['night_shift_rate'] ?? 1.35);
        $holidayRate = (float) ($settings['holiday_rate'] ?? 1.4);
        $insuranceRate = (float) ($settings['insurance_rate'] ?? 0.07);
        $taxFreeThreshold = (float) ($settings['tax_free_threshold'] ?? 100000000);
        $taxRate = (float) ($settings['tax_rate'] ?? 0.1);
        $childAllowance = (float) ($settings['child_allowance'] ?? 1000000);
        $spouseAllowance = (float) ($settings['spouse_allowance'] ?? 1500000);

        $data = $employee->toArray();
        $baseSalary = (float) $data['base_salary'];

        $dailyWage = $standardDays > 0 ? $baseSalary / $standardDays : 0.0;
        $hourlyWage = ($standardDays * $hoursPerDay) > 0 ? $baseSalary / ($standardDays * $hoursPerDay) : 0.0;

        $grossBeforeTax = $baseSalary
            + $hourlyWage * $overtimeRate * (float) $data['overtime_hours']
            + $hourlyWage * $nightShiftRate * (float) $data['night_shift_hours']
            + $hourlyWage * $holidayRate * (float) $data['holiday_hours']
            + $childAllowance * (int) $data['children_count']
            + ($data['has_spouse'] ? $spouseAllowance : 0.0)
            + (float) $data['extra_benefits'];

        $taxableBase = max(0.0, $grossBeforeTax - $taxFreeThreshold);
        $incomeTax = $taxableBase * $taxRate;
        $insurance = $baseSalary * $insuranceRate;

        return array_merge($data, [
            'standard_days' => $standardDays,
            'hours_per_day' => $hoursPerDay,
            'overtime_rate' => $overtimeRate,
            'night_shift_rate' => $nightShiftRate,
            'holiday_rate' => $holidayRate,
            'insurance_rate' => $insuranceRate,
            'tax_free_threshold' => $taxFreeThreshold,
            'tax_rate' => $taxRate,
            'child_allowance' => $childAllowance,
            'spouse_allowance' => $spouseAllowance,
            'daily_wage' => $dailyWage,
            'hourly_wage' => $hourlyWage,
            'gross_before_tax' => $grossBeforeTax,
            'taxable_base' => $taxableBase,
            'income_tax' => $incomeTax,
            'insurance' => $insurance,
        ]);
    }
}
