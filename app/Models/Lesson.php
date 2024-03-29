<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'sequence_number',
        'title',
        'content',
    ];

    /**
     * Returns current program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(ProgramInProgrammingLanguage::class);
    }

    public function test()
    {
        return $this->hasOne(Test::class);
    }
}
