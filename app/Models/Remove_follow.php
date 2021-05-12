<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remove_follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'creator_id',
        'cause',
        'content'
    ];

}
