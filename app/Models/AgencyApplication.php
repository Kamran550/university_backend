<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyApplication extends Model
{
    protected $fillable = [
        'application_id',
        'agency_name',
        'country',
        'city',
        'address',
        'website',
        'contact_name',
        'contact_phone',
        'contact_email',
        'business_license_path',
        'company_logo_path',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the application that owns the agency application.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
