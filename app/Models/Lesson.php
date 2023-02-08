<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequence_number',
        'title',
        'content',
    ];

    /**
     * Returns current program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program(){
        return $this->belongsTo(ProgramInProgrammingLanguage::class);
    }
}
