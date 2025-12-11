<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramTranslation extends Model
{
    
    use HasFactory, SoftDeletes;
    protected $table = 'program_translations';

    protected $fillable = [
        'program_id',
        'language',
        'name',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
