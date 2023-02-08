<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammingLanguage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'logo',
    ];

    /**
     * Returns programs in this programming language
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany programs
     */
    public function programs(){
        return $this->hasMany(ProgramInProgrammingLanguage::class);
    }
}
