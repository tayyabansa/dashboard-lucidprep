<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'subject_type',
        'question_type',
        'difficulty',
        'question_mode',
        'content',
        'options',
        'correct_answer',
        'explanation',
        'created_at',
    ];
    
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    
}
