<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'creator_id',
        'next_payment_date',
        'payment_status',
    ];
}
