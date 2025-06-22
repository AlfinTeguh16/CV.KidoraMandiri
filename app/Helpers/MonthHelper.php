<?php

namespace App\Helpers;

class MonthHelper
{
    /**
     * Get an array of months in Indonesian or English.
     *
     * @param string $locale
     * @return array
     */
    public static function getMonths(string $locale = 'id'): array
    {
        $months = [
            'id' => [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ],
            'en' => [
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
                7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
            ],
        ];

        return $months[$locale] ?? $months['id'];
    }

    /**
     * Get the name of a specific month by number.
     *
     * @param int $monthNumber
     * @param string $locale
     * @return string|null
     */
    public static function getMonthName(int $monthNumber, string $locale = 'id'): ?string
    {
        $months = self::getMonths($locale);
        return $months[$monthNumber] ?? null;
    }
}
