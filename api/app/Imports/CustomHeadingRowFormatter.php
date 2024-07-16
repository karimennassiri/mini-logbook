<?php

namespace App\Imports;

use Maatwebsite\Excel\HeadingRow\HeadingRowFormatter;

class CustomHeadingRowFormatter extends HeadingRowFormatter
{
    /**
     * Format the header row.
     *
     * @param  string  $value
     * @return string
     */
    public static function format($value)
    {
        return $value;
    }
}