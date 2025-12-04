<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    protected $fillable = [
        'degree_id',
        'faculty_id',
        'name',
        'price_per_year',
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
}
