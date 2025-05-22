<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pesanan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function home()
    {
        $obats = Obat::with('jenis')->get();
        return view('frontend.home', compact('obats'));
    }

    public function pengajuan()
    {
        $user = auth()->user();
        $pengajuans = $user->profile ? $user->profile->pengajuans()->latest()->get() : collect();
        return view('frontend.pengajuan', compact('pengajuans'));
    }

    public function pesanan()
    {
        $user = auth()->user();
        $pesanans = $user->profile ? $user->profile->pesanans()->with('items')->latest()->get() : collect();
        return view('frontend.pesanan', compact('pesanans'));
    }

    public function pesananresep()
    {
        $user = auth()->user();
        $pesananResep = $user->profile ? $user->profile->pesanans()->whereNotNull('pengajuan_id')->with('items')->latest()->get() : collect();
        return view('frontend.pesananresep', compact('pesananResep'));
    }

    public function profile()
    {
        $user = auth()->user();
        $profile = $user->profile;
        return view('frontend.profile', compact('user', 'profile'));
    }

    public function pesananDetail($id)
    {
        $user = auth()->user();
        $pesanan = Pesanan::with(['items.obat', 'profile'])->findOrFail($id);

        // Hanya pemilik pesanan yang boleh melihat
        if ($pesanan->profile->user_id !== $user->id) {
            abort(403, 'Tidak diizinkan mengakses pesanan ini.');
        }

        return view('frontend.pesanan-detail', compact('pesanan'));
    }

    // ✅ Method untuk handle form pengajuan resep
    public function submitPesananResep(Request $request)
{
    $request->validate([
        'uploadResep' => 'required|image|max:2048',
        'catatan' => 'nullable|string',
    ]);

    $user = auth()->user();
    $profile = $user->profile;

    if (!$profile) {
        return redirect()->back()->with('error', 'Profil tidak ditemukan.');
    }

    // Simpan file resep ke storage
    $imagePath = $request->file('uploadResep')->store('resep', 'public');

    // Ambil data dari form (hasil hitung GPS via JS)
    $jarak = $request->jarak ?? 0;
    $ongkir = $request->total ?? 0;
    $alamat = $request->alamat ?? $profile->alamat ?? 'Alamat tidak diketahui';

    // Simpan ke database
    Pengajuan::create([
        'profile_id' => $profile->id,
        'nomor_pengajuan' => 'PNJ-' . strtoupper(Str::random(8)),
        'catatan' => $request->catatan,
        'tanggal' => now(),
        'alamat' => $alamat,
        'jarak' => $jarak,
        'total' => $ongkir,
        'status' => 'menunggu',
        'image' => $imagePath,
    ]);

    return redirect()->route('frontend.pengajuan')->with('success', 'Pengajuan berhasil dikirim!');
}

}
