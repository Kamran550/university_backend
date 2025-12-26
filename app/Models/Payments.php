<?php

namespace App\Models;

use App\Enums\PaymentTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentMethodEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payments extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'payment_type',
        'academic_year',
        'semester',
        'amount',
        'status',
        'payment_method',
        'invoiced_number',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'payment_type' => PaymentTypeEnum::class,
            'status' => PaymentStatusEnum::class,
            'payment_method' => PaymentMethodEnum::class,
            'amount' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the payment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
