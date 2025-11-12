<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\PersianFormatter;

class Employee
{
    public function __construct(
        public readonly string $code,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $position,
        public readonly string $department,
        public readonly string $nationalId,
        public readonly string $employmentDate,
        public readonly int $baseSalary,
        public readonly int $workDays,
        public readonly array $allowances = [],
        public readonly array $deductions = [],
    ) {
    }

    public function fullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function employmentDateJalali(): string
    {
        return PersianFormatter::toJalali($this->employmentDate);
    }

    public static function sample(): self
    {
        return new self(
            code: 'EMP-1403-01',
            firstName: 'زهرا',
            lastName: 'کاظمی',
            position: 'کارشناس ارشد منابع انسانی',
            department: 'منابع انسانی',
            nationalId: '0012345678',
            employmentDate: '2020-03-21',
            baseSalary: 120_000_000,
            workDays: 26,
            allowances: config('payroll.allowances'),
            deductions: config('payroll.deductions'),
        );
    }
}
