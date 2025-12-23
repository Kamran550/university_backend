<?php

namespace App\Enums;

enum DocumentStatusEnum: string
{
    case ACCAPTANCE_LETTER = 'acceptance_letter';
    case CERTIFICATE_ENGLISH_LETTER = 'certificate_english';
    case CERTIFICATE_TURKISH_LETTER = 'certificate_turkish';
    case DIPLOMA_LETTER = 'diploma';
    case TRANSFER_ENGLISH_LETTER = 'transfer_english';
    case TRANSFER_TURKISH_LETTER = 'transfer_turkish';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
