<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerOptionForTest extends Model
{
    use HasFactory;

    protected $table = 'answer_options_for_test';

    protected $fillable = [
        'question_for_test_id',
        'text',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(QuestionForTest::class);
    }
}
