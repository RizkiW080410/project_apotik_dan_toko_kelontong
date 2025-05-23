<?php

use Livewire\Livewire;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesananController;
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


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [FrontendController::class, 'index'])
    ->name('frontend');

// Autentikasi
Route::post('/login',    [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('frontend');
})->name('logout');

// Semua ini dipanggil setelah user login
Route::middleware('auth')->group(function () {
    // Buat pesanan & generate snap_token
    Route::post('/checkout', [CheckoutController::class, 'store'])
         ->name('checkout.store');

    // Update status setelah pembayaran di‐widget Snap
    Route::post('/checkout/status', [CheckoutController::class, 'updateStatus'])
         ->name('checkout.status');
});