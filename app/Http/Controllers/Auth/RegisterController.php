<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

use Mail;
use App\Mail\EmailVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

//    /**
//     * Where to redirect users after registration.
//     *
//     * @var string
//     */
//    //protected $redirectTo = RouteServiceProvider::HOME;
//    //21.02.21 김태영, 계정 생성 후 리다이렉션 경로 변경
////    protected $redirectTo = '/user';
//    protected $redirectTo = '/mypage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest');
//        21.05.15 kondo,　仮登録から本登録ページでミドルウェアが適用されないように
        $this->middleware('guest', ['except' => ['preRegistered', 'registerPaymentNoSelect', 'registered']]);
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
            //21.05.13 kondo, 仮登録用
            'email_verify_token' => base64_encode($data['email']),
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
        //    21.05.13 kondo, 仮登録の為
        $fc_id = $data['fc_id'];
        $email = new EmailVerification($user,$fc_id);
        Mail::to($user->email) ->send($email);

        return $user;
    }

//    21.04.02 김태영, 생성
    protected function showRegistrationForm(Request $request) {
        $fc_id=$request->fc_id;
        $Prefectures = Prefecture::select('id', 'name')->orderby('id')->get();

        return view('auth.register', compact('Prefectures','fc_id'));
    }

//    21.05.13 kondo, 仮登録の為
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create( $request->all() )));
        return redirect(route('preRegistered.show'));
    }
    // 仮登録完了画面
    public function preRegistered(){
        return view('auth/pre_registered');
    }
    // 決済方法登録
    public function registerPayment($email_token,Request $request){
        //無効なtoken
        if ( !User::where('email_verify_token','=',$email_token)->exists()){
            return redirect(route('error.show'))->with('flash_message', "無効なトークンです。\n再度アクセスし直してください。");
        } else {
            //token有効
            $user = User::where('email_verify_token','=',$email_token)->first();
            //tokenとメールアドレスが一致するか確認
            if( $user->email != $request->email){
                return redirect(route('error.show'))->with('flash_message', "無効なトークンです。\n再度アクセスし直してください。");
            }
            //本登録すみの場合
            if ($user->status == config('const.USER_STATUS.REGISTER')) {
                return redirect(route('error.show'))->with('flash_message', "すでに本登録されています。\nログインして利用してください。");
            }
            $user->status = config('const.USER_STATUS.MAIL_AUTHED');
            $user->email_verified_at = Carbon::now();

            if ($user->save()) {
                $fc_id=$request->fc_id;
                //210714 kondo, 選択ページありでカード情報は別ページに
                return view('payment/select', compact('email_token','user','fc_id'));

                //21.07.11 김태영, save a payment method
                //stripe로 확정
                //au, softbank.. 통신사 결제 없음
                //return view('payment/select', compact('email_token','user','fc_id'));
            } else {
                return redirect(route('error.show'))->with('flash_message', "メール認証に失敗しました。\n再度、メールからリンクをクリックしてください。");
            }
        }
    }
    // 決済方法選択
    public function registerPaymentSelect(Request $request){
        $user_id = $request->user_id;
        $payment_select = $request->payment_select;
        //カードの時
        if ($payment_select == 'credit_card') {
            $fc_id = $request->fc_id;
//            dd('stripe画面へ');
//            return redirect(url('/register/credit_card?user_id='. $user_id .'&fc_id=' . $fc_id));
            return redirect(url('/register/paymentMethod/credit_card?user_id='. $user_id .'&fc_id=' . $fc_id));
        }
        return redirect('/')->with('flash_message', "会員登録に失敗しました。\n再度、メールからリンクをクリックしてください。");
    }
    //210714 kondo, stripeページ表示
    public function registerCard(Request $request){
//        dd('test');
        $user = User::find($request->user_id);
        //21.07.11 김태영, make a customer
        //stripe id = customer id
        $user->createOrGetStripeCustomer();
        return view('payment/update-payment-method', [
            'intent' => $user->createSetupIntent()
        ]);
    }
    // 決済方法登録せずに会員登録
    public function registerPaymentNoSelect(Request $request){
        $user = User::find($request->user_id);
        $user->status = config('const.USER_STATUS.REGISTER');
        if ($user->save()) {
            Auth::login($user);
            $fc_id=$request->fc_id;
            return redirect(url('/registered?fc_id='.$fc_id));
        }
        return redirect('/')->with('flash_message', "会員登録に失敗しました。\n再度、メールからリンクをクリックしてください。");
    }
    // 仮登録完了画面
    public function registered(Request $request){
        if($request->fc_id) {
            $creator = Creator::where('user_id', $request->fc_id)->first();
            if ($creator) {
                $user = User::find($creator->user_id);
            }
            return view('auth/registered',compact('creator','user'));
        }
    return view('auth/registered');
    }
}
