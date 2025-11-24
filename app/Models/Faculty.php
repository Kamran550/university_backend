<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Faculty extends Model
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
     * Get the degrees for the faculty.
     */
    public function degrees(): BelongsToMany
    {
        return $this->belongsToMany(Degree::class);
    }
}
