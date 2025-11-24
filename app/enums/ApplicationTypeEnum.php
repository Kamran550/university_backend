<?php

namespace App\Enums;

enum ApplicationTypeEnum: string
{
    //
    case STUDENT = 'student';
    case AGENCY = 'agency';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
