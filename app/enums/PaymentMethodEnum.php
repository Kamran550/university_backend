<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CASH = 'cash';
    case CARD = 'card';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

