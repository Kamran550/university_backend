<?php

namespace App\Enums;

enum ScholarshipStatusEnum: string
{
    case PERCENT_75 = '75%';
    case PERCENT_100 = '100%';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
