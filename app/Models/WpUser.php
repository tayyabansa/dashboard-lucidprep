<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class WpUser extends Authenticatable
{
    protected $table = 'wper_users'; // WordPress users table
    protected $primaryKey = 'ID'; // WordPress uses 'ID' instead of 'id'
    public $timestamps = false; // WordPress doesn't have Laravel's timestamps

    protected $fillable = [
        'user_login', 'user_pass', 'display_name', 'user_email'
    ];
}