<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;
    protected $table = 'test_results';

     protected $fillable = [
        'user_id', 'test_id', 'question_id',
        'user_answer', 'correct_answer', 'is_correct',
        'time_spent', 'accuracy', 'questions_status', 'status'
    ];
     public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
