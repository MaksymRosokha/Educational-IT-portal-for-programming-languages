<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramInProgrammingLanguage extends Model
{
    use HasFactory;

    /**
     * The current name table.
     * @var string
     */
    public $table = 'programs_in_programming_language';

    protected $fillable = [
        'name',
        'image',
        'description',
    ];

    /**
     * Returns programming language of this program
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo programming language
     */
    public function programmingLanguage(){
        return $this->belongsTo(ProgrammingLanguage::class);
    }

    /**
     * Returns this program`s lessons.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons(){
        return $this->hasMany(Lesson::class, "program_id");
    }
}
