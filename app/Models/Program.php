<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory, SoftDeletes;
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    protected $fillable = [
        'degree_id',
        'faculty_id',
        'name',
        'price_per_year',
        'is_thesis',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
    public function studyLanguages(): HasMany
    {
        return $this->hasMany(ProgramStudyLanguage::class);
    }
    public function translations()
    {
        return $this->hasMany(ProgramTranslation::class);
    }

    public function getName($lang = 'EN')
    {
        return $this->translations
            ->where('language', strtoupper($lang))
            ->first()
            ->name ?? '';
    }
}
