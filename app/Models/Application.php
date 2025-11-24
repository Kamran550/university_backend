<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Enums\ApplicationStatusEnum;

class Application extends Model
{
    protected $fillable = [
        'applicant_type',
        'degree_id',
        'degree_name',
        'faculty_id',
        'faculty_name',
        'status',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
        'ip_address',
        'user_agent',
        'locale',
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
     * Get the degree that owns the application.
     */
    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    /**
     * Get the faculty that owns the application.
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
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
}
