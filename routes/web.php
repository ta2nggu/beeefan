<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 *  for all
 *  middleware：nothing
 */
Route::get('/', function () {
    return view('index');
})->name('top');

Auth::routes();//이렇게 작성하면 verification.verify, resend.. 등 자동으로 router가 생김
Auth::routes(['verify' => true]);

//21.04.06 kondo, login page
Route::get('/creator/login', [App\Http\Controllers\PagesController::class, 'creatorLogin'])->name('creator_login');
Route::get('/admin/login', [App\Http\Controllers\PagesController::class, 'adminLogin'])->name('admin_login');

//21.04.06 kondo, help page
Route::get('/page/rule', [App\Http\Controllers\PagesController::class, 'pageRule'])->name('pageRule');
Route::get('/page/policy', [App\Http\Controllers\PagesController::class, 'pagePolicy'])->name('pagePolicy');
Route::get('/page/law', [App\Http\Controllers\PagesController::class, 'pageLaw'])->name('pageLaw');
Route::get('/page/help', [App\Http\Controllers\PagesController::class, 'pageHelp'])->name('pageHelp');

//21.05.12 kondo, beeefan account remove（ユーザーのみアカウント削除）
Route::get('/remove', [App\Http\Controllers\UserController::class, 'removeAccount'])->name('removeAccount.show');
Route::post('/remove', [App\Http\Controllers\UserController::class, 'removeAccountForm'])->name('removeAccount.post');
Route::get('/exit', [App\Http\Controllers\UserController::class, 'accountExit'])->name('exit.show');

//21.05.17 kondo, error page
Route::get('error/{code}', function ($code) { abort($code); });
Route::get('error', [App\Http\Controllers\PagesController::class, 'errorShow'])->name('error.show');
Route::get('/error_invalid', [App\Http\Controllers\PagesController::class, 'accountInvalid'])->name('accountInvalid.show');
Route::post('/error_invalid_post', [App\Http\Controllers\PagesController::class, 'accountInvalidPost'])->name('accountInvalid.post'); //無効アカウント削除

/**
 *  for accountUser　(ユーザー：仮登録)
 *  middleware：nothing
 */
Route::get('/register/pre_registered', [App\Http\Controllers\Auth\RegisterController::class, 'preRegistered'])->name('preRegistered.show'); //仮登録完了
Route::get('/register/{email_token}', [App\Http\Controllers\Auth\RegisterController::class, 'registerPayment'])->name('registerPayment.show'); //決済選択
Route::post('/register/paymentSelect', [App\Http\Controllers\Auth\RegisterController::class, 'registerPaymentSelect'])->name('registerPaymentSelect'); //決済方法登録登録
//21.07.25 김태영, /register/paymentMethod/credit_card 추가
Route::get('/register/paymentMethod/credit_card', [App\Http\Controllers\Auth\RegisterController::class, 'registerCard'])->name('registerCard.show'); //カード情報入力画面
Route::get('/register/credit_card', [App\Http\Controllers\Auth\RegisterController::class, 'registerCard'])->name('registerCard.show'); //カード情報入力画面
Route::post('/register/NoSelect', [App\Http\Controllers\Auth\RegisterController::class, 'registerPaymentNoSelect'])->name('registerPaymentNoSelect'); //あとで登録

/**
 *  for role:user　(ユーザー：会員登録済み)
 *  middleware：role:user
 */
Route::middleware('role:user')->group(function () {
    //21.05.14 kondo, 本登録完了
    Route::get('/registered', [App\Http\Controllers\Auth\RegisterController::class, 'registered'])->name('registered');
});

/**
 *  for accountUser　(メール認証済み)
 *  middleware：verified
 */
Route::middleware('verified')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
});

/**
 *  for role:user　(メール認証済み・仮登録済み)
 *  middleware：verified & loginUserCheck(status:!1)
 */
Route::middleware('verified','loginUserCheck')->group(function () {
    //user mypage
    Route::get('/mypage', [App\Http\Controllers\UserController::class, 'userIndex'])->name('userIndex');
    //21.04.06 김태영, middleware 제거 비로그인 user 접근도 허용
    Route::post('/join', [App\Http\Controllers\UserController::class, 'joinStore']);
    Route::get('/{creator}/joinOk', [App\Http\Controllers\UserController::class, 'joinOk']);
    //21.05.10 kondo, 入会中ファンクラブ詳細/退会
    Route::get('/mypage/fc/{account_id}', [App\Http\Controllers\UserController::class, 'joinFc'])->name('joinFc');
    Route::get('/mypage/fc/{account_id}/remove', [App\Http\Controllers\UserController::class, 'removeFc'])->name('removeFc');
    Route::post('/mypage/fc/remove', [App\Http\Controllers\UserController::class, 'removeFcForm'])->name('removeFcForm');
    //21.05.14 김태영, User Mypage -> 가입중인 모든 creator Timeline
    Route::get('/mypage/p', [App\Http\Controllers\UserController::class, 'timeline_followings']);
});

/**
 *  for all
 *  middleware：nothing
 *  （※なぜかここじゃないとエラーに）
 */
//21.03.21 김태영, User가 Creator 페이지 접속
//21.04.06 김태영, middleware 제거 비로그인 user 접근도 허용
//Route::get('/{creator}', [App\Http\Controllers\UserController::class, 'creatorIndex'])->name('user')->middleware('verified');
Route::get('/{creator}', [App\Http\Controllers\UserController::class, 'creatorIndex']);
//21.04.06 김태영, middleware 제거 비로그인 user 접근도 허용
//Route::get('/{creator}/timeline/{start}', [App\Http\Controllers\UserController::class, 'timeline'])->middleware('verified');
Route::get('/{creator}/p/{start}', [App\Http\Controllers\UserController::class, 'timeline']);
Route::get('/{creator}/join', [App\Http\Controllers\UserController::class, 'join']);
//Route::post('/join', [App\Http\Controllers\CurlController::class, 'postCurl']);

/**
 *  for role:creator　(メール認証済み)
 *  middleware：verified
 */
Route::middleware('verified')->group(function () {
    //Route::get('/creator', [App\Http\Controllers\CreatorController::class, 'index'])->name('creator')->middleware('verified');
    //Route::get('/creator/{creator}', [App\Http\Controllers\CreatorController::class, 'index'])->name('creator')->middleware('verified');
    Route::get('/creator/index', [App\Http\Controllers\CreatorController::class, 'index'])->name('creator');
    Route::get('/creator/write', [App\Http\Controllers\CreatorController::class, 'write'])->name('write');
    Route::get('/creator/setting', [App\Http\Controllers\CreatorController::class, 'creatorSetting'])->name('creatorSetting');
    Route::post('/creator/setting', [App\Http\Controllers\CreatorController::class, 'creatorSetting_store'])->name('creatorSetting_store');
    //21.04.29 김태영, 下書き投稿一覧 초안 투고 리스트 화면, 비공개 투고 조회 화면으로
    Route::get('/creator/invisible', [App\Http\Controllers\CreatorController::class, 'invisibleTweets']);
    Route::get('/creator/invisibleTime/{start}', [App\Http\Controllers\CreatorController::class, 'invisibleTweetsTime']);
    //21.04.30 김태영, 비공개 투고 삭제
    Route::post('/creator/delTweet', [App\Http\Controllers\CreatorController::class, 'delTweet']);
    //21.05.06 kondo, 공개투고→삭제
    Route::post('/creator/delTweetPost', [App\Http\Controllers\CreatorController::class, 'delTweetPost']);
    //21.05.06 kondo, 공개투고/비공개 変更
    Route::post('/creator/ChangeTweetInvisible', [App\Http\Controllers\CreatorController::class, 'ChangeTweetInvisible']);
    Route::post('/creator/ChangeTweetPost', [App\Http\Controllers\CreatorController::class, 'ChangeTweetPost']);
    //21.04.30 김태영, 투고 편집
    Route::get('/creator/edit/{tweet_id}', [App\Http\Controllers\CreatorController::class, 'edit'])->name('edit');
    //Route::post('/upload', [App\Http\Controllers\ImageController::class, 'store'])->name('/app/upload')->middleware('verified');
    Route::post('/creator/creator_write/preview/',[App\Http\Controllers\CreatorController::class, 'preview'])->name('creator_write.preview');
    Route::get('image/{filename}', [App\Http\Controllers\ImageController::class,'getPubliclyStorgeFile'])->name('image.displayImage');
});

/**
 *  for role:admin & superadministrator　(メール認証済み)
 *  middleware：verified
 */
Route::middleware('verified')->group(function () {
    Route::get('/admin/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::get('/admin/creators', [App\Http\Controllers\AdminController::class, 'admin_creatorList'])->name('admin_creatorList');
    Route::get('/admin/creatorReg', [App\Http\Controllers\AdminController::class, 'admin_creatorRegPage'])->name('admin_creatorRegPage');
    Route::post('/admin/creatorReg', [App\Http\Controllers\AdminController::class, 'admin_creatorReg'])->name('admin_creatorReg');
    //21.05.04 김태영, 공지사항
    Route::get('/admin/notice', [App\Http\Controllers\AdminController::class, 'notice']);
    Route::post('/admin/notice', [App\Http\Controllers\AdminController::class, 'notice_store']);
    Route::post('/admin/delNotice', [App\Http\Controllers\AdminController::class, 'notice_delete']);
    //21.05.10 김태영, creator 관리
    Route::get('/admin/creator-{admin}', [App\Http\Controllers\AdminController::class, 'creatorDetail'])->name('AdminCreatorDetail');
    Route::post('/creator/visible', [App\Http\Controllers\AdminController::class, 'updateCreatorVisible']);
    Route::post('/creator/del', [App\Http\Controllers\AdminController::class, 'deleteCreator']);

});
//21.07.13 김태영, save stripe payment method
Route::post('/stripe/savePaymentMethod', [App\Http\Controllers\SubscriptionController::class, 'paymentMethod_store']);

/**
 *  for role:superadministrator　(メール認証済み)
 *  middleware：verified
 */
Route::middleware('verified','role:superadministrator')->group(function () {
    //21.05.08 김태영, admin 관리
    Route::get('/admin/admins/{admin}', [App\Http\Controllers\AdminController::class, 'admins']);
    Route::get('/admin/adminReg', [App\Http\Controllers\AdminController::class, 'adminReg']);
    Route::post('/admin/adminReg', [App\Http\Controllers\AdminController::class, 'adminReg_store']);
    Route::get('/aDetail/{admin}', [App\Http\Controllers\AdminController::class, 'adminDetail']);
    Route::post('/admin/del', [App\Http\Controllers\AdminController::class, 'admin_delete']);
    //21.05.10 김태영, creator 관리 price change
    Route::post('/creator/month_price', [App\Http\Controllers\AdminController::class, 'updateCreatorPrice']);
});

/**
 *  for accountUser　(メール認証済み・仮登録済み)
 *  middleware：verified & loginUserCheck(status:!1)
 */
Route::middleware('verified','loginUserCheck')->group(function () {
    //21.04.26 김태영
    //Route::get('/password/change', [App\Http\Controllers\UserController::class, 'change_password'])->middleware('verified');
    Route::get('/password/{change}', [App\Http\Controllers\UserController::class, 'change_password']);
    //21.05.11 김태영, admin이 creator의 비밀번호를 변경 시
    Route::get('/password/creator/{change}', [App\Http\Controllers\UserController::class, 'change_creator_password']);
    Route::post('/password/change', [App\Http\Controllers\UserController::class, 'change_password_store']);

    //Route::get('/email/change', [App\Http\Controllers\UserController::class, 'change_email'])->middleware('verified');
    Route::get('/email/{change}', [App\Http\Controllers\UserController::class, 'change_email']);
    Route::post('/email/change', [App\Http\Controllers\UserController::class, 'change_email_store']);
});
