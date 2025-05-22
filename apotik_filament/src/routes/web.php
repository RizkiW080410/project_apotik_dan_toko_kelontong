<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontendController;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
// Route::get('/', function () {
//     return view('welcome');
// });
// ✅ Halaman publik
    Route::get('/', [FrontendController::class, 'home'])->name('home');
// ✅ Autentikasi
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ✅ Halaman yang butuh login
Route::middleware(['auth'])->group(function () {
    
    Route::get('/pesananresep', [FrontendController::class, 'pesananresep']);
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/pengajuan', [FrontendController::class, 'pengajuan']);
    Route::get('/pesanan', [FrontendController::class, 'pesanan']);
    Route::get('/profile', [FrontendController::class, 'profile']);
});
