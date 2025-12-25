<?php

namespace App\Enums;

enum PaymentTypeEnum: string
{
    case DEPOSIT = 'Deposit';
    case TUITION = 'Tuition';
    case ANNUAL = 'Annual';
    case OTHER = 'Other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
