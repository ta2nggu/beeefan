<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'visible',
        'msg',
        'main_img',
        'main_img_mime_type',
        'main_img_idx',
    ];
}
