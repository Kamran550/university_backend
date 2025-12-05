<?php

namespace App\Enums;

enum DocumentTypeEnum: string
{
    case ACCEPTANCE = 'acceptance';
    case CERTIFICATE = 'certificate';
    case DIPLOMA = 'diploma';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
