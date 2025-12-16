<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentApplication extends Model
{
    use HasFactory, SoftDeletes;
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
        'high_school_diploma_path',
        'high_school_transcript_path',
        'bachelor_diploma_path',
        'bachelor_transcript_path',
        'master_diploma_path',
        'master_transcript_path',
        
        'student_number',
        'passport_number',
        'study_language',
        'application_number',
        'diploma_number',
        'diploma_text',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'diploma_text' => 'array',
    ];

    /**
     * Get the application that owns the student application.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Generate a unique verification code for the acceptance letter.
     */

    /**
     * Get verification URL for the acceptance letter.
     */
    public function getVerificationUrl(?string $verificationCode = null): string
    {
        $domain = config('app.verify_domain', 'verify.eipu.edu.pl');
        $url = "https://{$domain}";

        if ($verificationCode) {
            $url .= "?verificationcode=" . urlencode($verificationCode);
        }

        return $url;
    }
}
