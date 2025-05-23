<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pesanan;
use App\Models\Pengajuan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    public function home()
    {
        $popularObats = Obat::with('jenis')
            ->withSum('pesananItems as total_terjual', 'qty')
            ->orderByDesc('total_terjual')
            ->limit(6)
            ->get();

        $obats = Obat::with('jenis')->get();

        return view('frontend.home', compact('obats', 'popularObats'));
    }

    public function pengajuan()
    {
        $user = auth()->user();
        $pengajuans = $user->profile
            ? $user->profile->pengajuans()->latest()->get()
            : collect();

        return view('frontend.pengajuan', compact('pengajuans'));
    }

    public function pesanan()
    {
        $user = auth()->user();
        $pesanans = $user->profile
            ? $user->profile
                ->pesanans()
                ->with([
                    'items.obat',
                    'profile.user',
                    'pengiriman',
                ])
                ->latest()
                ->get()
            : collect();

        return view('frontend.pesanan', compact('pesanans'));
    }

    public function pesananresep()
    {
        $user = auth()->user();
        $pesananResep = $user->profile
            ? $user->profile
                ->pesanans()
                ->whereNotNull('pengajuan_id')
                ->with('items', 'pengiriman')
                ->latest()
                ->get()
            : collect();

        return view('frontend.pesananresep', compact('pesananResep'));
    }

    public function profile()
    {
        $user = auth()->user();
        $profile = $user->profile;
        return view('frontend.profile', compact('user', 'profile'));
    }

    /**
     * Handle form pengajuan resep:
     * 1) Buat Pengajuan
     * 2) Dari Pengajuan → Buat Pesanan
     * 3) Dari Pesanan → Buat Pengiriman (simpan ongkir)
     */
    public function submitPesananResep(Request $request)
    {
        $request->validate([
            'uploadResep' => 'required|image|max:2048',
            'catatan'     => 'nullable|string',
            'jarak'       => 'required|numeric',
            'total'       => 'required|numeric',   // ini ongkir
            'alamat'      => 'required|string',
        ]);

        $user    = auth()->user();
        $profile = $user->profile;
        if (! $profile) {
            return redirect()->back()->with('error', 'Profil tidak ditemukan.');
        }

        // Simpan file resep
        $imagePath = $request->file('uploadResep')->store('resep', 'public');

        $jarak  = $request->jarak;
        $ongkir = $request->total;
        $alamat = $request->alamat;

        DB::transaction(function () use ($profile, $jarak, $ongkir, $alamat, $request, $imagePath) {
            // 1) Pengajuan
            $pengajuan = Pengajuan::create([
                'profile_id'      => $profile->id,
                'nomor_pengajuan' => 'PNJ-' . strtoupper(Str::random(8)),
                'catatan'         => $request->catatan,
                'tanggal'         => now(),
                'alamat'          => $alamat,
                'jarak'           => $jarak,
                'total'           => $ongkir,
                'status'          => 'menunggu',
                'image'           => $imagePath,
            ]);

            // 2) Pesanan
            $pesanan = $pengajuan->pesanans()->create([
                'profile_id'    => $profile->id,
                'tanggal'       => now(),
                'total'         => $ongkir,
                'status'        => 'menunggu',
            ]);

            // 3) Pengiriman (ongkir)
            $pesanan->pengiriman()->create([
                'alamat'    => $alamat,
                'jarak'     => $jarak,
                'total'     => $ongkir,
                'status'    => 'menunggu',
            ]);
        });

        return redirect()
            ->route('frontend.pengajuan')
            ->with('success', 'Pengajuan resep dan pesanan berhasil dibuat!');
    }
}
