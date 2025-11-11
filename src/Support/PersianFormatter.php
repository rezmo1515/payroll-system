<?php

declare(strict_types=1);

namespace App\Support;

final class PersianFormatter
{
    private const DIGIT_MAP = [
        '0' => '۰',
        '1' => '۱',
        '2' => '۲',
        '3' => '۳',
        '4' => '۴',
        '5' => '۵',
        '6' => '۶',
        '7' => '۷',
        '8' => '۸',
        '9' => '۹',
    ];

    public static function toPersianDigits(string $value): string
    {
        return strtr($value, self::DIGIT_MAP);
    }

    public static function formatCurrency(float $amount): string
    {
        $formatted = number_format($amount, 0, '.', ',');
        return self::toPersianDigits($formatted) . ' ریال';
    }

    public static function formatDate(
        \DateTimeInterface $date,
        string $separator = ' '
    ): string {
        $jalali = self::gregorianToJalali((int) $date->format('Y'), (int) $date->format('m'), (int) $date->format('d'));
        $months = [
            1 => 'فروردین',
            2 => 'اردیبهشت',
            3 => 'خرداد',
            4 => 'تیر',
            5 => 'مرداد',
            6 => 'شهریور',
            7 => 'مهر',
            8 => 'آبان',
            9 => 'آذر',
            10 => 'دی',
            11 => 'بهمن',
            12 => 'اسفند',
        ];

        $day = self::toPersianDigits((string) $jalali['day']);
        $month = $months[$jalali['month']] ?? '';
        $year = self::toPersianDigits((string) $jalali['year']);

        return trim($day . $separator . $month . $separator . $year);
    }

    /**
     * Simple Gregorian to Jalali conversion.
     *
     * @return array{year:int, month:int, day:int}
     */
    public static function gregorianToJalali(int $gy, int $gm, int $gd): array
    {
        $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        $gy2 = $gy - 1600;
        $gm2 = $gm - 1;
        $gd2 = $gd - 1;

        $g_day_no = 365 * $gy2 + (int) (($gy2 + 3) / 4) - (int) (($gy2 + 99) / 100) + (int) (($gy2 + 399) / 400);
        $g_day_no += $g_d_m[$gm2] + $gd2;

        if ($gm2 > 1 && (($gy % 4 === 0 && $gy % 100 !== 0) || ($gy % 400 === 0))) {
            $g_day_no++;
        }

        $j_day_no = $g_day_no - 79;
        $j_np = (int) ($j_day_no / 12053);
        $j_day_no %= 12053;

        $jy = 979 + 33 * $j_np + 4 * (int) ($j_day_no / 1461);
        $j_day_no %= 1461;

        if ($j_day_no >= 366) {
            $jy += (int) (($j_day_no - 1) / 365);
            $j_day_no = ($j_day_no - 1) % 365;
        }

        $jm = $j_day_no < 186 ? 1 + (int) ($j_day_no / 31) : 7 + (int) (($j_day_no - 186) / 30);
        $jd = 1 + ($j_day_no < 186 ? $j_day_no % 31 : ($j_day_no - 186) % 30);

        return ['year' => $jy, 'month' => $jm, 'day' => $jd];
    }
}
