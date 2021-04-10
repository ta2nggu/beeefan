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

Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware('verified');

//21.03.21 김태영, User가 Creator 페이지 접속
Route::get('/{creator}', [App\Http\Controllers\UserController::class, 'creatorIndex'])->name('user')->middleware('verified');
Route::get('/{creator}/timeline/{start}', [App\Http\Controllers\UserController::class, 'timeline'])->middleware('verified');

//Route::get('/creator', [App\Http\Controllers\CreatorController::class, 'index'])->name('creator')->middleware('verified');
//Route::get('/creator/{creator}', [App\Http\Controllers\CreatorController::class, 'index'])->name('creator')->middleware('verified');
Route::get('/creator/index', [App\Http\Controllers\CreatorController::class, 'index'])->name('creator')->middleware('verified');
Route::get('/creator/write', [App\Http\Controllers\CreatorController::class, 'write'])->name('write')->middleware('verified');
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
//testpage
Route::get('/test/02-1', [PagesController::class, 'test1'])->name('test');
Route::get('/test/02-2', [PagesController::class, 'test2'])->name('test');
Route::get('/test/03-2', [PagesController::class, 'test3'])->name('test');
Route::get('/test/03-4', [PagesController::class, 'test5'])->name('test');
