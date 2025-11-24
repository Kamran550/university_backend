<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Degree extends Model
{
    protected $fillable = [
        'name',
    ];
    

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot',
    ];

    /**
     * Get the faculties for the degree.
     */
    public function faculties(): BelongsToMany
    {
        return $this->belongsToMany(Faculty::class);
    }
}
