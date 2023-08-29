<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('post', [AdminController::class, 'post'])->name('post');
        Route::post('store', [AdminController::class, 'store'])->name('store');
        Route::get('show', [AdminController::class, 'show'])->name('show');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    });
});


require __DIR__ . '/auth.php';
