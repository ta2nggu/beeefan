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

Route::get('/mypage', [App\Http\Controllers\UserController::class, 'index'])->name('userIndex')->middleware('verified');
//21.05.12 kondo, beeefan退会（ユーザーのみアカウント削除）
Route::get('/page/remove', [App\Http\Controllers\UserController::class, 'removeAccount'])->name('removeAccount');
Route::post('/page/remove', [App\Http\Controllers\UserController::class, 'removeAccountForm'])->name('removeAccountForm');

//21.05.10 kondo, 入会中ファンクラブ詳細/退会
Route::get('/mypage/fc/{account_id}', [App\Http\Controllers\UserController::class, 'joinFc'])->name('joinFc');
Route::get('/mypage/fc/{account_id}/remove', [App\Http\Controllers\UserController::class, 'removeFc'])->name('removeFc');
Route::post('/mypage/fc/remove', [App\Http\Controllers\UserController::class, 'removeFcForm'])->name('removeFcForm');

//21.03.21 김태영, User가 Creator 페이지 접속
//21.04.06 김태영, middleware 제거 비로그인 user 접근도 허용
//Route::get('/{creator}', [App\Http\Controllers\UserController::class, 'creatorIndex'])->name('user')->middleware('verified');
Route::get('/{creator}', [App\Http\Controllers\UserController::class, 'creatorIndex']);
//21.04.06 김태영, middleware 제거 비로그인 user 접근도 허용
//Route::get('/{creator}/timeline/{start}', [App\Http\Controllers\UserController::class, 'timeline'])->middleware('verified');
Route::get('/{creator}/p/{start}', [App\Http\Controllers\UserController::class, 'timeline']);
Route::get('/{creator}/join', [App\Http\Controllers\UserController::class, 'join'])->middleware('verified');
Route::post('/join', [App\Http\Controllers\UserController::class, 'joinStore']);
//Route::post('/join', [App\Http\Controllers\CurlController::class, 'postCurl']);
Route::get('/{creator}/joinOk', [App\Http\Controllers\UserController::class, 'joinOk'])->middleware('verified');
//21.05.14 김태영, User Mypage -> 가입중인 모든 creator Timeline
Route::get('/mypage/p', [App\Http\Controllers\UserController::class, 'timeline_followings'])->middleware('verified');

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
//21.05.06 kondo, 공개투고→삭제
Route::post('/creator/delTweetPost', [App\Http\Controllers\CreatorController::class, 'delTweetPost']);
//21.05.06 kondo, 공개투고/비공개 変更
Route::post('/creator/ChangeTweetInvisible', [App\Http\Controllers\CreatorController::class, 'ChangeTweetInvisible']);
Route::post('/creator/ChangeTweetPost', [App\Http\Controllers\CreatorController::class, 'ChangeTweetPost']);
//21.04.30 김태영, 투고 편집
Route::get('/creator/edit/{tweet_id}', [App\Http\Controllers\CreatorController::class, 'edit'])->name('edit')->middleware('verified');
//Route::post('/upload', [App\Http\Controllers\ImageController::class, 'store'])->name('/app/upload')->middleware('verified');
Route::post('/creator/creator_write/preview/',[App\Http\Controllers\CreatorController::class, 'preview'])->name('creator_write.preview');
Route::get('image/{filename}', [App\Http\Controllers\ImageController::class,'getPubliclyStorgeFile'])->name('image.displayImage');

Route::get('/admin/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin')->middleware('verified');
Route::get('/admin/creators', [App\Http\Controllers\AdminController::class, 'admin_creatorList'])->name('admin_creatorList')->middleware('verified');
Route::get('/admin/creatorReg', [App\Http\Controllers\AdminController::class, 'admin_creatorRegPage'])->name('admin_creatorRegPage')->middleware('verified');
Route::post('/admin/creatorReg', [App\Http\Controllers\AdminController::class, 'admin_creatorReg'])->name('admin_creatorReg')->middleware('verified');
//21.05.04 김태영, 공지사항
Route::get('/admin/notice', [App\Http\Controllers\AdminController::class, 'notice'])->middleware('verified');
Route::post('/admin/notice', [App\Http\Controllers\AdminController::class, 'notice_store'])->middleware('verified');
Route::post('/admin/delNotice', [App\Http\Controllers\AdminController::class, 'notice_delete'])->middleware('verified');
//21.05.08 김태영, admin 관리
Route::get('/admin/admins/{admin}', [App\Http\Controllers\AdminController::class, 'admins'])->middleware('role:superadministrator');
Route::get('/admin/adminReg', [App\Http\Controllers\AdminController::class, 'adminReg'])->middleware('role:superadministrator');
Route::post('/admin/adminReg', [App\Http\Controllers\AdminController::class, 'adminReg_store'])->middleware('role:superadministrator');
Route::get('/aDetail/{admin}', [App\Http\Controllers\AdminController::class, 'adminDetail'])->middleware('role:superadministrator');
Route::post('/admin/del', [App\Http\Controllers\AdminController::class, 'admin_delete'])->middleware('role:superadministrator');
//21.05.10 김태영, creator 관리
Route::get('/admin/creator-{admin}', [App\Http\Controllers\AdminController::class, 'creatorDetail'])->middleware('role:administrator|superadministrator');
Route::post('/creator/month_price', [App\Http\Controllers\AdminController::class, 'updateCreatorPrice'])->middleware('role:superadministrator');
Route::post('/creator/visible', [App\Http\Controllers\AdminController::class, 'updateCreatorVisible'])->middleware('role:administrator|superadministrator');
Route::post('/creator/del', [App\Http\Controllers\AdminController::class, 'deleteCreator'])->middleware('role:administrator|superadministrator');

//21.04.06 kondo
Route::get('/creator/login', [App\Http\Controllers\PagesController::class, 'creatorLogin'])->name('creator_login');
Route::get('/admin/login', [App\Http\Controllers\PagesController::class, 'adminLogin'])->name('admin_login');
Route::get('/page/rule', [App\Http\Controllers\PagesController::class, 'pageRule'])->name('pageRule');
Route::get('/page/policy', [App\Http\Controllers\PagesController::class, 'pagePolicy'])->name('pagePolicy');
Route::get('/page/law', [App\Http\Controllers\PagesController::class, 'pageLaw'])->name('pageLaw');
Route::get('/page/help', [App\Http\Controllers\PagesController::class, 'pageHelp'])->name('pageHelp');

//21.04.26 김태영
//Route::get('/password/change', [App\Http\Controllers\UserController::class, 'change_password'])->middleware('verified');
Route::get('/password/{change}', [App\Http\Controllers\UserController::class, 'change_password'])->middleware('verified');
//21.05.11 김태영, admin이 creator의 비밀번호를 변경 시
Route::get('/password/creator/{change}', [App\Http\Controllers\UserController::class, 'change_creator_password'])->middleware('verified');
Route::post('/password/change', [App\Http\Controllers\UserController::class, 'change_password_store'])->middleware('verified');

//Route::get('/email/change', [App\Http\Controllers\UserController::class, 'change_email'])->middleware('verified');
Route::get('/email/{change}', [App\Http\Controllers\UserController::class, 'change_email'])->middleware('verified');
Route::post('/email/change', [App\Http\Controllers\UserController::class, 'change_email_store'])->middleware('verified');
