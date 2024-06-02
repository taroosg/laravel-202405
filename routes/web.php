<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 検索のルーティング
// 検索画面を表示するルーティング
Route::get('tweets/search', [TweetController::class, 'search'])->name('tweets.search');
// キーワードを受け取って検索結果を表示するルーティング
Route::post('tweets/find', [TweetController::class, 'find'])->name('tweets.find');
// 自分のtweetを一覧表示するルーティング
Route::get('tweets/mypage', [TweetController::class, 'mypage'])->name('tweets.mypage');

// CRUD処理のルーティング
Route::resource('tweets', TweetController::class);

require __DIR__ . '/auth.php';
