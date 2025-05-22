<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pesanan;
use App\Models\Pengiriman;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'cart.*.obat_id' => 'required|exists:obats,id',
            'cart.*.qty' => 'required|integer|min:1',
            'ongkir' => 'required|integer',
            'alamat' => 'required|string|max:255',
            'jarak' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Ambil profile pengguna
            $profile = Auth::user()->profile;

            if (!$profile) {
                return response()->json(['message' => 'Profil pengguna tidak ditemukan.'], 400);
            }

            // Buat pesanan
            $pesanan = new Pesanan();
            $pesanan->profile_id = $profile->id;
            $pesanan->tanggal = now();
            $pesanan->status = 'menunggu';
            $pesanan->save(); // nomor_pesanan dan total akan diisi otomatis lewat model event

            // Simpan item
            foreach ($request->cart as $item) {
                $obat = Obat::findOrFail($item['obat_id']);
                PesananItem::create([
                    'pesanan_id' => $pesanan->id,
                    'obat_id' => $obat->id,
                    'qty' => $item['qty'],
                    'total' => $obat->harga * $item['qty'],
                ]);
            }

            // Buat pengiriman
            Pengiriman::create([
                'pesanan_id' => $pesanan->id,
                'alamat' => $request->alamat,
                'jarak' => $request->jarak,
                'total' => $request->ongkir,
                'status' => 'menunggu',
            ]);

            DB::commit();

            return response()->json(['message' => 'Pesanan berhasil dibuat.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal membuat pesanan', 'error' => $e->getMessage()], 500);
        }
    }
}
