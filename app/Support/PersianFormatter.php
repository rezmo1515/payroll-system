<?php

declare(strict_types=1);

namespace App\Support;

use IntlDateFormatter;
use IntlGregorianCalendar;

class PersianFormatter
{
    public static function formatCurrency(int|float $amount): string
    {
        $formatted = number_format((float) $amount, 0, '.', ',');
        $persianDigits = ['0','1','2','3','4','5','6','7','8','9'];
        $westernDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];

        return str_replace($persianDigits, $westernDigits, $formatted) . ' ریال';
    }

    public static function toPersianDigits(string $value): string
    {
        $persianDigits = ['0','1','2','3','4','5','6','7','8','9'];
        $westernDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];

        return str_replace($persianDigits, $westernDigits, $value);
    }

    public static function toJalali(string $gregorianDate): string
    {
        $date = new \DateTimeImmutable($gregorianDate);
        $formatter = new IntlDateFormatter(
            'fa_IR@calendar=persian',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'Asia/Tehran',
            IntlDateFormatter::TRADITIONAL,
            'd MMMM yyyy'
        );
        $formatter->setCalendar(new IntlGregorianCalendar('Asia/Tehran'));
        $formatted = $formatter->format($date);

        if (! $formatted) {
            return self::toPersianDigits($date->format('Y-m-d'));
        }

        return self::toPersianDigits($formatted);
    }
}
