<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pesanan;
use App\Models\Pengiriman;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.obat_id' => 'required|exists:obats,id',
            'cart.*.qty' => 'required|integer|min:1',
            'ongkir' => 'required|integer',
            'alamat' => 'required|string|max:255',
            'jarak' => 'required|numeric',
        ]);

        try {
            $user = Auth::user()->load('profile');
            $profile = $user->profile;

            if (!$profile) {
                $profile = $user->profile()->create([
                    'nama_lengkap' => $user->name,
                    'nomor_telepon' => '-',
                    'jenis_kelamin' => 'Laki-laki',
                    'tanggal_lahir' => now()->subYears(20),
                ]);
            }

            DB::beginTransaction();

            $pesanan = new Pesanan();
            $pesanan->profile_id = $profile->id;
            $pesanan->tanggal = now();
            $pesanan->status = 'menunggu';
            $pesanan->total = 0; // sementara
            $pesanan->save();

            // Generate nomor pesanan manual setelah save (gunakan ID)
            $pesanan->nomor_pesanan = 'PSN-' . str_pad($pesanan->id, 6, '0', STR_PAD_LEFT);
            $pesanan->save();

            $totalProduk = 0;

            foreach ($validated['cart'] as $item) {
                $obat = Obat::findOrFail($item['obat_id']);
                $subtotal = $obat->harga * $item['qty'];
                $totalProduk += $subtotal;

                PesananItem::create([
                    'pesanan_id' => $pesanan->id,
                    'obat_id' => $obat->id,
                    'qty' => $item['qty'],
                    'total' => $subtotal,
                ]);
            }

            $pesanan->total = $totalProduk + $validated['ongkir'];
            $pesanan->save();

            Pengiriman::create([
                'pesanan_id' => $pesanan->id,
                'alamat' => $validated['alamat'],
                'jarak' => $validated['jarak'],
                'total' => $validated['ongkir'],
                'status' => 'menunggu',
                'pengirim_id' => null,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil dibuat.'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Gagal membuat pesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
