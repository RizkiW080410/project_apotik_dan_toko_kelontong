<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Inisialisasi Midtrans (ambil dari config/midtrans.php)
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * 1) Proses checkout: simpan header, item, pengiriman, hitung total, generate Snap token
     */
    public function store(Request $request)
    {
        $v = $request->validate([
            'cart'           => 'required|array|min:1',
            'cart.*.id'      => 'required|exists:products,id',
            'cart.*.qty'     => 'required|integer|min:1',
            'cart.*.price'   => 'required|integer|min:0',
            'alamat'         => 'required|string|max:255',
            'jarak'          => 'required|numeric',
            'ongkir'         => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            // 1) Buat header pesanan (nomor_pesanan diisi otomatis di model Pesanan::creating)
            $pesanan = Pesanan::create([
                'pembeli_id' => auth()->user()->pembeli->id,
                'status'     => 'tunggu',
                'total'      => 0,  // akan direcalc nanti
            ]);

            // 2) Simpan detail item & siapkan array untuk Midtrans
            $midtransItems = [];
            foreach ($v['cart'] as $row) {
                PesananItem::create([
                    'pesanan_id' => $pesanan->id,
                    'product_id' => $row['id'],
                    'qty'        => $row['qty'],
                    'total'      => $row['qty'] * $row['price'],
                ]);
                $p = Product::find($row['id']);
                $midtransItems[] = [
                    'id'       => $row['id'],
                    'price'    => $row['price'],
                    'quantity' => $row['qty'],
                    'name'     => $p->name,
                ];
            }

            // 3) Simpan pengiriman
            Pengiriman::create([
                'pesanan_id' => $pesanan->id,
                'alamat'     => $v['alamat'],
                'jarak'      => $v['jarak'],
                'total'      => $v['ongkir'],
                'status'     => 'konfirmasi',
            ]);

            // 4) Tambahkan ongkir ke daftar item Midtrans
            $midtransItems[] = [
                'id'       => 'ONGKIR',
                'price'    => $v['ongkir'],
                'quantity' => 1,
                'name'     => 'Ongkos Kirim',
            ];

            // 5) Hitung ulang total header (trigger event updated di model Pesanan)
            //    Kita bisa langsung assign + save() atau memanggil recalculateTotal()
            $pesanan->total = $pesanan->items()->sum('total') + $v['ongkir'];
            $pesanan->save();

            // 6) Generate Snap token
            $orderIdFull = $pesanan->nomor_pesanan . '-' . now()->timestamp;
            $snapToken   = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id'     => $orderIdFull,
                    'gross_amount' => $pesanan->total,
                ],
                'item_details'     => $midtransItems,
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email'      => auth()->user()->email,
                ],
            ]);

            DB::commit();

            return response()->json([
                'success'       => true,
                'snap_token'    => $snapToken,
                'order_id_full' => $orderIdFull,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error', ['msg' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * 2) Update status setelah callback JS Midtrans (onSuccess / onPending)
     */
    public function updateStatus(Request $request)
    {
        Log::info('Midtrans updateStatus', $request->all());

        $v = $request->validate([
            'order_id_full'      => 'required|string',
            'transaction_status' => 'required|string',
        ]);

        // Parse PSN-xxxxxx
        $parts = explode('-', $v['order_id_full']);
        $base  = count($parts) >= 3
               ? $parts[0].'-'.$parts[1]
               : $v['order_id_full'];

        $pesanan = Pesanan::where('nomor_pesanan', $base)->first();
        if (! $pesanan) {
            return response()->json(['success'=>false,'message'=>'Pesanan tidak ditemukan'], 404);
        }

        // Map status
        if (in_array($v['transaction_status'], ['deny','cancel','expire'])) {
            $pesanan->status = 'dibatalkan';
        } else {
            $pesanan->status = 'diproses';
        }
        $pesanan->save();

        return response()->json([
            'success'        => true,
            'pesanan_status' => $pesanan->status,
        ], 200);
    }
}
