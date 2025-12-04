<?php

namespace App\Enums;

enum DocumentTypeEnum: string
{
    case ACCEPTANCE = 'acceptance';
    case CERTIFICATE = 'certificate';


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
