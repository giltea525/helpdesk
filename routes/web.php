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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth/login');//Laravel画面なしでログイン画面表示する('/'はデフォルトルート)
});

use App\Http\Controllers\ContactController;
Route::group(['middleware' => 'auth'], function () {
//新規入力画面を表示する
Route::get('/contact/create',[ContactController::class,'add'])->name('contact.add');
//テーブルにデータを格納する
Route::post('/contact/create',[ContactController::class,'create'])->name('contact.create');
//一覧を表示
// Route::get('contact/index',[ContactController::class,'index'])->name('contact.index');
Route::get('/home',[ContactController::class,'index'])->name('contact.index');//一覧画面のURLが/homeになる＝ナビゲーションバーのHomeボタンのリンク先
//編集画面
Route::get('contact/edit', [ContactController::class,'edit'])->name('contact.edit');
//更新を保存する
Route::post('contact/edit', [ContactController::class,'update'])->name('contact.update');
//削除する
Route::get('contact/delete', [ContactController::class,'delete'])->name('contact.delete');
});

Auth::routes();
//Home画面を表示させないので省略する
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
