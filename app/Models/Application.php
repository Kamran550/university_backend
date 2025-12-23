<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\ApplicationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Application extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'program_id',
        'applicant_type',
        'faculty_name',
        'status',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
        'user_id',
        'ip_address',
        'user_agent',
        'locale',
        'document_status',
        
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => ApplicationStatusEnum::class,
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the program that owns the application.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the student application for the application.
     */
    public function studentApplication(): HasOne
    {
        return $this->hasOne(StudentApplication::class);
    }

    /**
     * Get the agency application for the application.
     */
    public function agencyApplication(): HasOne
    {
        return $this->hasOne(AgencyApplication::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the document verifications for the application.
     */
    public function documentVerifications(): HasMany
    {
        return $this->hasMany(DocumentVerification::class);
    }
}
