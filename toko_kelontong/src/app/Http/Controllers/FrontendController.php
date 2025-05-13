<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index() {
        $products = Product::with('category')->where('status', 'ready')->get();

        $pesanans = [];
        if (Auth::check()) {
            $pesanans = Pesanan::with(['items.product', 'pengiriman.pengirim'])
                ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
                ->latest()
                ->get();
        }
        return view('index', compact('products', 'pesanans'));
    }
}
