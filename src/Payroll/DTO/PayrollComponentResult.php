<?php

declare(strict_types=1);

namespace App\Payroll\DTO;

final class PayrollComponentResult
{
    public function __construct(
        public readonly string $key,
        public readonly string $title,
        public readonly string $category,
        public readonly string $type,
        public readonly float $amount,
        public readonly string $description
    ) {
    }
}
