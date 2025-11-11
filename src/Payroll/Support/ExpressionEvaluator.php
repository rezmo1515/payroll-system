<?php

declare(strict_types=1);

namespace App\Payroll\Support;

use InvalidArgumentException;

final class ExpressionEvaluator
{
    /**
     * @param array<string, float|int|bool> $variables
     */
    public function evaluate(string $expression, array $variables): float
    {
        $this->guardExpression($expression);

        $normalized = preg_replace('/\s+/', ' ', trim($expression));
        if ($normalized === '' || $normalized === null) {
            return 0.0;
        }

        $code = preg_replace_callback(
            '/\b([a-zA-Z_][a-zA-Z0-9_]*)\b/',
            function (array $matches) use ($variables): string {
                $token = $matches[1];
                $allowedFunctions = ['max', 'min', 'round', 'ceil', 'floor', 'abs'];

                if (in_array($token, $allowedFunctions, true)) {
                    return '\\' . $token;
                }

                if (!array_key_exists($token, $variables)) {
                    return '0';
                }

                return '($__vars[\'' . $token . '\'] ?? 0)';
            },
            $normalized
        );

        $code ??= '0';
        $code = str_replace('\\\\', '\\', $code);

        $previous = error_reporting();
        error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

        try {
            $result = eval('$_result = 0; $__vars = ' . var_export($variables, true) . '; return ' . $code . ';');
        } catch (\Throwable $throwable) {
            throw new InvalidArgumentException('Payroll expression failed: ' . $throwable->getMessage(), 0, $throwable);
        } finally {
            error_reporting($previous);
        }

        if (!is_numeric($result)) {
            throw new InvalidArgumentException('Payroll expression did not resolve to a numeric value.');
        }

        return (float) $result;
    }

    private function guardExpression(string $expression): void
    {
        if (preg_match('/[^0-9+*\-\/().,_ a-zA-Z?:]/u', $expression)) {
            throw new InvalidArgumentException('Expression contains unsupported characters.');
        }
    }
}
