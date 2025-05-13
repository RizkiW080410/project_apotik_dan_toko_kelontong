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

Route::get('/', [FrontendController::class, 'index'])->name('frontend');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Route::middleware('auth')->post('/checkout', [CheckoutController::class, 'store']);
Route::post('/payment/callback', function (Request $request) {
    $serverKey = env('MIDTRANS_SERVER_KEY');
    $signature = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    if ($signature === $request->signature_key) {
        $pesanan = Pesanan::where('nomor_pesanan', $request->order_id)->first();

        if ($pesanan) {
            $pesanan->update([
                'status' => $request->transaction_status === 'settlement' ? 'diproses' : $pesanan->status,
                'payment_type' => $request->payment_type ?? null,
                'transaction_status' => $request->transaction_status ?? null,
                'fraud_status' => $request->fraud_status ?? null,
                'bank' => $request->va_numbers[0]['bank'] ?? null,
                'va_number' => $request->va_numbers[0]['va_number'] ?? null,
            ]);
        }
    }

    return response()->json(['message' => 'Callback processed']);
});