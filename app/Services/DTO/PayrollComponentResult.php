<?php

declare(strict_types=1);

namespace App\Services\DTO;

class PayrollComponentResult
{
    public function __construct(
        public readonly string $name,
        public readonly string $code,
        public readonly int $amount,
    ) {
    }
}
