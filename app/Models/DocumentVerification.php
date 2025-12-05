<?php

namespace App\Models;

use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'document_type',
        'verification_code',
        'file_path',
        'verified_at',
    ];

    protected $casts = [
        'document_type' => DocumentTypeEnum::class,
        'verified_at' => 'datetime',
    ];

    /**
     * Get the application that owns the document verification.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
