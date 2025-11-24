<?php

namespace App\Enums;

enum ApplicationStatusEnum: string
{
    case PENDING = 'pending';
    case UNDER_REVIEW = 'under_review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
    