<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function terakhir(Request $request)
    {
        $pesanan = Pesanan::with(['items.product', 'pengiriman'])
            ->where('pembeli_id', auth()->user()->pembeli->id)
            ->latest()
            ->first();

        if (!$pesanan) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan']);
        }

        return response()->json([
            'success' => true,
            'pesanan' => [
                'nomor_pesanan' => $pesanan->nomor_pesanan,
                'status' => $pesanan->status,
                'total' => $pesanan->total,
                'items' => $pesanan->items->map(function ($item) {
                    return [
                        'nama_produk' => $item->product->name,
                        'qty' => $item->qty,
                        'total' => $item->total
                    ];
                }),
                'pengiriman' => $pesanan->pengiriman ? [
                    'alamat' => $pesanan->pengiriman->alamat,
                    'total' => $pesanan->pengiriman->total
                ] : null
            ]
        ]);
    }
}
