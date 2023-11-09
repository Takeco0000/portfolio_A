<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/store', [App\Http\Controllers\ItemController::class, 'store']);

    // アイテム検索機能
    Route::get('/items', [App\Http\Controllers\ItemController::class, 'index'])->name('items.index');
    // 商品編集
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit']);
    Route::post('/update/{id}', [App\Http\Controllers\ItemController::class, 'update']);
    // 商品削除
    Route::post('/delete', [App\Http\Controllers\ItemController::class, 'delete']);
    // csv出力
    Route::get('/csv', [App\Http\Controllers\ItemController::class, 'csv']);
});
