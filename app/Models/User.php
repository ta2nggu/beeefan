<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
//21.03.30 김태영, 회원가입 email 인증 customize
use App\Notifications;

class User extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'name',
//        21.04.15 김태영
//        name -> last_name, first_name
//        price_month 月額 추가
        'last_name',
        'first_name',
        'month_price',
        'email',
        'password',
        'account_id',
        'sex',
        'prefecture_id',
        'nickname',
        'birth_date',// 모델에 fillable 에 추가해야 db 필드에 값이 들어감
        'email_verified_at',//21.04.14 김태영, email_verified_at 추가, fillable에 있어야지만 필드에 insert 나 update 할 수 있음
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'datetime',
    ];

//    21.03.30 김태영, 회원가입 email 인증 customize
    public function sendEmailVerificationNotification()
    {
        $this->notify(new Notifications\VerifyEmail); // Replace this with your custom notification class
    }
}
