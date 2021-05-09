<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Prefecture;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    //21.02.21 김태영, 계정 생성 후 리다이렉션 경로 변경
//    protected $redirectTo = '/user';
    protected $redirectTo = '/mypage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
//            'name' => ['required', 'string', 'max:255'],
//        21.04.04 김태영, account_id, prefecture_id 추가, nickname 제거
//        21.04.29 kondo, sex 추가
            'account_id' => ['required', 'string', 'min:2', 'max:20','unique:users', 'regex:/^[\w-]*$/'],
            'sex' => ['required'],
            'prefecture_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            //'nickname' => ['required','string','min:2','unique:users','regex:/(^([a-zA-Z]+)(\d+)?$)/u'],
//            'nickname' => ['required','string','min:2','unique:users','regex:/^\S*$/u'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//            'nickname' => $data['nickname'],
//            'birth_date' => $data['birth_date'],
//        ]);

        //21.02.21 김태영, role 부여
        $user = User::create([
//            21.04.04 김태영, 일반 user 이름 제거
//            'name' => $data['name'],
//            21.04.04 김태영, account_id, sex, prefecture_id 추가, nickname 제거
            'account_id' => $data['account_id'],
            'sex' => $data['sex'],
            'prefecture_id' => $data['prefecture_id'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
//            'nickname' => $data['nickname'],
            'birth_date' => $data['birth_date'],
        ]);

        if ($data['role'] === 'user') {
            $user->attachRole('user');
        }
        else if ($data['role'] === 'superadministrator') {
            $user->attachRole('superadministrator');
        }
        else if ($data['role'] === 'administrator') {
            $user->attachRole('administrator');
        }
        else if ($data['role'] === 'creator') {
            $user->attachRole('creator');
        }
        return $user;
    }

//    21.04.02 김태영, 생성
    protected function showRegistrationForm() {
        $Prefectures = Prefecture::select('id', 'name')->orderby('id')->get();

        return view('auth.register', compact('Prefectures'));
    }

}
