<?php

declare(strict_types=1);

namespace App\View;

class View
{
    public function __construct(private string $template, private array $data = [])
    {
    }

    public function render(): string
    {
        $templatePath = __DIR__ . '/../../resources/views/' . str_replace('.', '/', $this->template) . '.php';

        if (! is_file($templatePath)) {
            throw new \RuntimeException("View template [{$this->template}] not found.");
        }

        extract($this->data, EXTR_SKIP);

        ob_start();
        include $templatePath;

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
