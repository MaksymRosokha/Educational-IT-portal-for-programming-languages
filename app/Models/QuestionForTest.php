<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionForTest extends Model
{
    use HasFactory;

    protected $table = 'questions_for_test';

    protected $fillable = [
        'test_id',
        'text',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answerOptions()
    {
        return $this->hasMany(AnswerOptionForTest::class);
    }
}
