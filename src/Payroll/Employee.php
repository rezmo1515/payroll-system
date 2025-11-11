<?php

declare(strict_types=1);

namespace App\Payroll;

final class Employee
{
    public function __construct(
        public readonly string $nationalCode,
        public readonly string $fullName,
        public readonly float $baseSalary,
        public readonly int $workDays,
        public readonly float $overtimeHours,
        public readonly float $nightShiftHours,
        public readonly float $holidayHours,
        public readonly int $absenceDays,
        public readonly int $childrenCount,
        public readonly bool $hasSpouse,
        public readonly float $extraBenefits,
        public readonly float $loanInstallment,
        public readonly float $otherDeductions
    ) {
    }

    public function toArray(): array
    {
        return [
            'national_code' => $this->nationalCode,
            'full_name' => $this->fullName,
            'base_salary' => $this->baseSalary,
            'work_days' => $this->workDays,
            'overtime_hours' => $this->overtimeHours,
            'night_shift_hours' => $this->nightShiftHours,
            'holiday_hours' => $this->holidayHours,
            'absence_days' => $this->absenceDays,
            'children_count' => $this->childrenCount,
            'has_spouse' => $this->hasSpouse,
            'extra_benefits' => $this->extraBenefits,
            'loan_installment' => $this->loanInstallment,
            'other_deductions' => $this->otherDeductions,
        ];
    }
}
