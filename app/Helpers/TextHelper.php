<?php

if (!function_exists('tr_upper')) {
    function tr_upper(string $text): string
    {
        $map = [
            'i' => 'İ',
            'ı' => 'I',
            'ğ' => 'Ğ',
            'ü' => 'Ü',
            'ş' => 'Ş',
            'ö' => 'Ö',
            'ç' => 'Ç',
            'ə' => 'Ə',
        ];

        return mb_strtoupper(strtr($text, $map), 'UTF-8');
    }
}



if (!function_exists('course_to_word')) {
    /**
     * Convert course number to Turkish ordinal word
     * 
     * @param int|null $course
     * @return string
     */
    function course_to_word(?int $course): string
    {
        if ($course === null) {
            return 'ikinci';
        }

        $words = [
            1 => 'birinci',
            2 => 'ikinci',
            3 => 'üçüncü',
            4 => 'dörtüncü',
            5 => 'beşinci',
            6 => 'altıncı',
        ];

        return $words[$course] ?? 'ikinci';
    }
}
