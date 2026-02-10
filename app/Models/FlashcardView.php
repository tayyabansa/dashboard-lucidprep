<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashcardView extends Model
{
    protected $table = 'flashcard_views';

    // ensure Eloquent manages created_at/updated_at
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'card_id',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];
}
