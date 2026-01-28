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
    Route::get('/hasil-prediksi', [App\Http\Controllers\HomeController::class, 'hasilPrediksi'])->name('hasil_prediksi');
    Route::post('/prediksiaction', [App\Http\Controllers\PrediksiController::class, 'prediksi'])->name('prediksiact');
    Route::get('/history', [App\Http\Controllers\HomeController::class, 'history'])->name('history');
    Route::get('/detail_history/{id}', [App\Http\Controllers\PrediksiController::class, 'detailHistory'])->name('detail_history');
    Route::post('/export_history', [App\Http\Controllers\PrediksiController::class, 'export'])->name('export_history');
});
