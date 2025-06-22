<?php

namespace App\Helpers;

class YearHelper
{
    /**
     * Mengembalikan array daftar tahun dalam rentang tertentu.
     *
     * @param int|null $startYear Tahun awal (default: 2000)
     * @param int|null $endYear Tahun akhir (default: current year + 5)
     * @param bool $descending Jika true, urutkan tahun secara menurun
     * @return array
     */
    public static function getYears(?int $startYear = null, ?int $endYear = null, bool $descending = false): array
    {
        $currentYear = (int) date('Y');
        $startYear = $startYear ?? 2000;
        $endYear = $endYear ?? ($currentYear + 5);

        $years = range($startYear, $endYear);

        if ($descending) {
            $years = array_reverse($years);
        }

        return $years;
    }

    /**
     * Mengembalikan nama tahun sebagai string.
     *
     * @param int $year
     * @return string
     */
    public static function getYearName(int $year): string
    {
        return (string) $year;
    }
}
