<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentApplication extends Model
{
    protected $fillable = [
        'application_id',
        'first_name',
        'last_name',
        'father_name',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'nationality',
        'native_language',
        'phone',
        'email',
        'country',
        'city',
        'address_line',
        'photo_id_path',
        'profile_photo_path',
        'diploma_path',
        'transcript_path',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the application that owns the student application.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
