<?php

declare(strict_types=1);

namespace App\Support;

class Str
{
    public function __construct(private string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function kebab(): string
    {
        return strtolower(preg_replace('/[^\p{L}\p{N}]+/u', '-', trim($this->value))) ?? '';
    }
}
