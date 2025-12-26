<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes (Website)
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/artikel/{slug}', [WebsiteController::class, 'detailartikel'])->name('artikel.detail');

// Admin Routes (Protected by Auth Middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('administrator.dashboard');
    })->name('dashboard');
    
    Route::resource('posts', PostController::class);
});

// Auth Routes
require __DIR__.'/auth.php';