<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    use HasFactory;

     protected $fillable = [
        'user_id',
        'subject_type',
        'test_mode',
        'question_mode',
        'question_type',
        'practice_type',
        'difficulty_levels',
        'selected_subjects',
        'selected_topics',
        'num_of_passages',
        'wp_test',
        'status',
        'exam_type',
    ];

    protected $casts = [
        'difficulty_levels' => 'array',
        'selected_subjects' => 'array',
    ];
    
    public function results()
    {
        return $this->hasMany(TestResult::class, 'test_id');
    }
}