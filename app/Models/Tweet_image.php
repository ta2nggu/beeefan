<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet_image extends Model
{
    use HasFactory;

    protected $fillable = [
        'private',
    ];
}
