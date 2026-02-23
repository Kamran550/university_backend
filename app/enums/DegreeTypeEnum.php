<?php

namespace App\Enums;

enum DegreeTypeEnum: string
{
    case BACHELOR = 'bachelor';
    case MASTER = 'master';
    case phD = 'phd';
    case MASTER_WITHOUT_THESIS = 'master_without_thesis';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
