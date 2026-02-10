<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;
    protected $table = 'decks';
    protected $fillable = [
        'user_id',
        'deck_name',
        'deck_color',
    ];


    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
