<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Degree extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'duration',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the programs for the degree.
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
    public function translations()
    {
        return $this->hasMany(DegreeTranslation::class);
    }

    public function getName($lang = 'EN')
    {
        return $this->translations
            ->where('language', strtoupper($lang))
            ->first()
            ->name ?? '';
    }
}
