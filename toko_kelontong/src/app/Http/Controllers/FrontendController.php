<?php
namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function index()
    {
        // Produk ready
        $products   = Product::with('category')->where('status','ready')->get();

        // Ambil semua kategori untuk filter di grid
        $categories = CategoryProduct::all();

        // Hitung total qty terjual per kategori
        $popular = CategoryProduct::select(
        'category_products.id',
        'category_products.name',
        'category_products.description',
        DB::raw('SUM(pesanan_items.qty) as sold')
        )
        ->join('products',      'products.category_product_id', '=', 'category_products.id')
        ->join('pesanan_items', 'pesanan_items.product_id',       '=', 'products.id')
        ->groupBy(
            'category_products.id',
            'category_products.name',
            'category_products.description'
        )
        ->orderByDesc('sold')
        ->take(8)
        ->get();

        // Pesanan user (untuk modal Pesanan)
        $pesanans = [];
        if (Auth::check()) {
            $pesanans = Pesanan::with(['items.product','pengiriman'])
                ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
                ->latest()
                ->get();
        }

        return view('index', compact('products','categories','popular','pesanans'));
    }
}
