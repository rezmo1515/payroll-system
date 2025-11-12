<?php

declare(strict_types=1);

namespace App\Services\DTO;

/**
 * @property-read PayrollComponentResult[] $allowances
 * @property-read PayrollComponentResult[] $deductions
 */
class PayrollResult
{
    /**
     * @param PayrollComponentResult[] $allowances
     * @param PayrollComponentResult[] $deductions
     */
    public function __construct(
        public readonly int $baseSalary,
        public readonly array $allowances,
        public readonly array $deductions,
    ) {
    }

    public function totalAllowances(): int
    {
        return array_sum(array_map(fn (PayrollComponentResult $item) => $item->amount, $this->allowances));
    }

    public function totalDeductions(): int
    {
        return array_sum(array_map(fn (PayrollComponentResult $item) => $item->amount, $this->deductions));
    }

    public function grossIncome(): int
    {
        return $this->baseSalary + $this->totalAllowances();
    }

    public function netIncome(): int
    {
        return $this->grossIncome() - $this->totalDeductions();
    }
}
