<?php

declare(strict_types=1);

namespace App\Modules;

class ModuleCatalogue
{
    /**
     * @return Module[]
     */
    public function all(): array
    {
        return array_map(
            fn (array $module) => new Module(
                $module['name'],
                $module['category'],
                $module['features'],
                $module['description'] ?? null,
            ),
            config('modules.items', [])
        );
    }

    /**
     * @return Module[]
     */
    public function featured(): array
    {
        return array_values(array_filter(
            $this->all(),
            fn (Module $module) => $module->category === 'ویژه'
        ));
    }
}
