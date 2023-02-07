<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('item.index');
    //商品登録画面を返す
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('item.edit');
    //商品登録画面で登録ボタンが押下されたとき
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('item.store');
    //商品編集画面を返す
    Route::get('/items/{item_id}/edit', [ItemController::class, 'edit'])->name('item.edit');
    //商品編集画面で更新ボタンが押されたとき
    Route::patch('/items/{item_id}', [ItemController::class, 'update'])->name('item.update');
    //削除機能
    Route::delete('/items/{item_id}', [ItemController::class, 'destroy'])->name('item.destroy');
});

Auth::routes();