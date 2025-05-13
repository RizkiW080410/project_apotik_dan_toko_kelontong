<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Pesanan;
use App\Models\Pengiriman;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Gunakan sandbox
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
            'alamat' => 'required|string',
            'jarak' => 'required|numeric',
            'ongkir' => 'required|integer',
            'total' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $pembeliId = auth()->user()->pembeli->id;

            // Buat pesanan dengan status "tunggu"
            $pesanan = Pesanan::create([
                'pembeli_id' => $pembeliId,
                'status' => 'tunggu',
                'total' => $validated['total'], // Sementara total dari input
            ]);

            // Simpan item pesanan
            foreach ($validated['items'] as $item) {
                PesananItem::create([
                    'pesanan_id' => $pesanan->id,
                    'product_id' => $item['id'],
                    'qty' => $item['qty'],
                    'total' => $item['qty'] * $item['price'],
                ]);
            }

            // Simpan pengiriman (tanpa pengirim)
            Pengiriman::create([
                'pesanan_id' => $pesanan->id,
                'pengirim_id' => null,
                'alamat' => $validated['alamat'],
                'jarak' => $validated['jarak'],
                'total' => $validated['ongkir'],
                'status' => 'konfirmasi',
            ]);

            // Commit DB
            DB::commit();

            // Buat Snap Token Midtrans
            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $pesanan->nomor_pesanan,
                    'gross_amount' => $validated['total'],
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'callbacks' => [
                    'finish' => url('/payment/success'),
                ],
            ];

            $snapToken = Snap::getSnapToken($midtransParams);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'pesanan_id' => $pesanan->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
