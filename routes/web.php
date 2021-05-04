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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', function () {
    return view('index');
});

Auth::routes();//이렇게 작성하면 verification.verify, resend.. 등 자동으로 router가 생김

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

Route::get('/mypage', [App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware('verified');
//21.05.03 kondo, ファンクラブ詳細（途中）
Route::get('/mypage/fanclub', [App\Http\Controllers\UserController::class, 'joinCreator']);


//21.03.21 김태영, User가 Creator 페이지 접속
//21.04.06 김태영, middleware 제거 비로그인 user 접근도 허용
//Route::get('/{creator}', [App\Http\Controllers\UserController::class, 'creatorIndex'])->name('user')->middleware('verified');
Route::get('/{creator}', [App\Http\Controllers\UserController::class, 'creatorIndex']);
//21.04.06 김태영, middleware 제거 비로그인 user 접근도 허용
//Route::get('/{creator}/timeline/{start}', [App\Http\Controllers\UserController::class, 'timeline'])->middleware('verified');
Route::get('/{creator}/timeline/{start}', [App\Http\Controllers\UserController::class, 'timeline']);
Route::get('/{creator}/join', [App\Http\Controllers\UserController::class, 'join'])->middleware('verified');
Route::post('/join', [App\Http\Controllers\UserController::class, 'joinStore']);
//Route::post('/join', [App\Http\Controllers\CurlController::class, 'postCurl']);
Route::get('/{creator}/joinOk', [App\Http\Controllers\UserController::class, 'joinOk'])->middleware('verified');

//Route::get('/creator', [App\Http\Controllers\CreatorController::class, 'index'])->name('creator')->middleware('verified');
//Route::get('/creator/{creator}', [App\Http\Controllers\CreatorController::class, 'index'])->name('creator')->middleware('verified');
Route::get('/creator/index', [App\Http\Controllers\CreatorController::class, 'index'])->name('creator')->middleware('verified');
Route::get('/creator/write', [App\Http\Controllers\CreatorController::class, 'write'])->name('write')->middleware('verified');
Route::get('/creator/mypage', [App\Http\Controllers\CreatorController::class, 'mypage'])->name('mypage')->middleware('verified');
Route::post('/creator/mypage', [App\Http\Controllers\CreatorController::class, 'mypage_store']);
//21.04.29 김태영, 下書き投稿一覧 초안 투고 리스트 화면, 비공개 투고 조회 화면으로
Route::get('/creator/invisible', [App\Http\Controllers\CreatorController::class, 'invisibleTweets'])->middleware('verified');
Route::get('/creator/invisibleTime/{start}', [App\Http\Controllers\CreatorController::class, 'invisibleTweetsTime'])->middleware('verified');
//21.04.30 김태영, 비공개 투고 삭제
Route::post('/creator/delTweet', [App\Http\Controllers\CreatorController::class, 'delTweet']);
//21.04.30 김태영, 투고 편집
Route::get('/creator/edit/{tweet_id}', [App\Http\Controllers\CreatorController::class, 'edit'])->name('edit')->middleware('verified');
//Route::post('/upload', [App\Http\Controllers\ImageController::class, 'store'])->name('/app/upload')->middleware('verified');
Route::post('/creator/creator_write/preview/',[App\Http\Controllers\CreatorController::class, 'preview'])->name('creator_write.preview');
Route::get('image/{filename}', [App\Http\Controllers\ImageController::class,'getPubliclyStorgeFile'])->name('image.displayImage');

Route::get('/admin/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin')->middleware('verified');
Route::get('/admin/creators', [App\Http\Controllers\AdminController::class, 'admin_creatorList'])->name('admin_creatorList')->middleware('verified');
Route::get('/admin/creatorReg', [App\Http\Controllers\AdminController::class, 'admin_creatorRegPage'])->name('admin_creatorRegPage')->middleware('verified');
Route::post('/admin/creatorReg', [App\Http\Controllers\AdminController::class, 'admin_creatorReg'])->name('admin_creatorReg')->middleware('verified');

//21.04.06 kondo creator&admin login page
use App\Http\Controllers\PagesController;
Route::get('/creator/login', [PagesController::class, 'creatorLogin'])->name('creator_login');
Route::get('/admin/login', [PagesController::class, 'adminLogin'])->name('admin_login');
Route::get('/page/rule', [PagesController::class, 'pageRule'])->name('pageRule');
Route::get('/page/policy', [PagesController::class, 'pagePolicy'])->name('pagePolicy');
Route::get('/page/law', [PagesController::class, 'pageLaw'])->name('pageLaw');
Route::get('/page/help', [PagesController::class, 'pageHelp'])->name('pageHelp');

//21.04.26 김태영
Route::get('/password/change', [App\Http\Controllers\UserController::class, 'change_password'])->middleware('verified');
Route::post('/password/change', [App\Http\Controllers\UserController::class, 'change_password_store'])->middleware('verified');

Route::get('/email/change', [App\Http\Controllers\UserController::class, 'change_email'])->middleware('verified');
Route::post('/email/change', [App\Http\Controllers\UserController::class, 'change_email_store'])->middleware('verified');
