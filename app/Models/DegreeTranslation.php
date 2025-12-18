<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DegreeTranslation extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'degree_translations';

    protected $fillable = [
        'degree_id',
        'language',
        'name',
        'description',
    ];


    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }
}
