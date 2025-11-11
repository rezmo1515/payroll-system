<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

use App\Payroll\Employee;
use App\Payroll\Services\PayrollCalculator;
use App\Support\PersianFormatter;

$employeeData = [
    'national_code' => '1234567890',
    'full_name' => 'علی رضایی',
    'base_salary' => 120000000,
    'work_days' => 30,
    'overtime_hours' => 12,
    'night_shift_hours' => 6,
    'holiday_hours' => 8,
    'absence_days' => 1,
    'children_count' => 2,
    'has_spouse' => true,
    'extra_benefits' => 15000000,
    'loan_installment' => 5000000,
    'other_deductions' => 2000000,
];

$employee = new Employee(
    nationalCode: $employeeData['national_code'],
    fullName: $employeeData['full_name'],
    baseSalary: (float) $employeeData['base_salary'],
    workDays: (int) $employeeData['work_days'],
    overtimeHours: (float) $employeeData['overtime_hours'],
    nightShiftHours: (float) $employeeData['night_shift_hours'],
    holidayHours: (float) $employeeData['holiday_hours'],
    absenceDays: (int) $employeeData['absence_days'],
    childrenCount: (int) $employeeData['children_count'],
    hasSpouse: (bool) $employeeData['has_spouse'],
    extraBenefits: (float) $employeeData['extra_benefits'],
    loanInstallment: (float) $employeeData['loan_installment'],
    otherDeductions: (float) $employeeData['other_deductions']
);

$calculator = PayrollCalculator::fromConfigPath(__DIR__ . '/../config/payroll.php');
$result = $calculator->calculate($employee);
$components = $result->components();

$issueDate = new DateTimeImmutable();
$persianDate = PersianFormatter::formatDate($issueDate);

include __DIR__ . '/../resources/views/payslip.php';
