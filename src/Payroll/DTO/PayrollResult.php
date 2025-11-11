<?php

declare(strict_types=1);

namespace App\Payroll\DTO;

final class PayrollResult
{
    /** @param PayrollComponentResult[] $components */
    public function __construct(
        private readonly array $components,
        private readonly float $earningTotal,
        private readonly float $deductionTotal,
        private readonly float $netPay
    ) {
    }

    /** @return PayrollComponentResult[] */
    public function components(): array
    {
        return $this->components;
    }

    public function earningTotal(): float
    {
        return $this->earningTotal;
    }

    public function deductionTotal(): float
    {
        return $this->deductionTotal;
    }

    public function netPay(): float
    {
        return $this->netPay;
    }
}
