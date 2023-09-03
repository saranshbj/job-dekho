<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;

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

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('view/{jobId}', [PublicController::class, 'viewJob'])->name('viewJob');


Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('post', [AdminController::class, 'post'])->name('post');
        Route::post('store', [AdminController::class, 'store'])->name('store');
        Route::get('show', [AdminController::class, 'show'])->name('show');
        Route::get('applicant', [AdminController::class, 'applicant'])->name('applicant');
        Route::put('updateStatus/{applicationId}', [AdminController::class, 'updateStatus'])->name('update');
        Route::get('viewProfile/{applicantId}', [AdminController::class, 'viewProfile'])->name('viewProfile');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::match(['get', 'post'],'profile/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('apply/{userId}', [UserController::class, 'apply'])->name('apply');
        Route::get('applied', [UserController::class, 'applied'])->name('applied');
    });
});


require __DIR__ . '/auth.php';
