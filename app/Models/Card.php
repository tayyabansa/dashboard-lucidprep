<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $table = 'card';

    protected $fillable = [
       'user_id', 
       'deck_id', 
       'front_content', 
       'back_content', 
       'tag',
   ];


   public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
