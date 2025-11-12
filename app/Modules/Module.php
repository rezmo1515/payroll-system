<?php

declare(strict_types=1);

namespace App\Modules;

class Module
{
    /**
     * @param string[] $features
     */
    public function __construct(
        public readonly string $name,
        public readonly string $category,
        public readonly array $features,
        public readonly ?string $description = null,
    ) {
    }
}
