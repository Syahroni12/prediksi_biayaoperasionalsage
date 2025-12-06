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
Route::get('/', [App\Http\Controllers\AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/loginaction', [App\Http\Controllers\AuthController::class, 'loginaction'])->name('loginaction')->middleware('guest');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/prediksi', [App\Http\Controllers\HomeController::class, 'prediksi'])->name('prediksi');
});
