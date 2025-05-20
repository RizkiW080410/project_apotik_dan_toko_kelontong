<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Pesanan;
use App\Models\Profile;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePesananRequest;
use App\Http\Requests\UpdatePesananRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyPesananRequest;

class PesananController extends Controller
{
    public function generateNomorPesanan()
    {
        // Ambil semua nomor yang sesuai format PSN-XXXXX
        $latest = \App\Models\Pesanan::where('nomor_pesanan', 'LIKE', 'PSN-%')
            ->get()
            ->map(function ($item) {
                if (preg_match('/PSN-(\d+)/', $item->nomor_pesanan, $match)) {
                    return (int)$match[1];
                }
                return 0;
            })
            ->max();

        $nextNumber = $latest + 1;

        return 'PSN-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        abort_if(Gate::denies('pesanan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pesanans = Pesanan::with(['profile', 'pengajuan', 'items.obat'])->get();

        return view('admin.pesanans.index', compact('pesanans'));
    }

    public function create()
    {
        abort_if(Gate::denies('pesanan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profiles = Profile::all();
        $pengajuans = Pengajuan::all();

        $newNomorPesanan = $this->generateNomorPesanan();

        return view('admin.pesanans.create', compact('profiles', 'pengajuans', 'newNomorPesanan'));
    }

    public function store(StorePesananRequest $request)
    {
        $nomorPesananBaru = $this->generateNomorPesanan();

        $pesanan = Pesanan::create([
            'profile_id' => $request->profile_id,
            'pengajuan_id' => $request->pengajuan_id,
            'nomor_pesanan' => $nomorPesananBaru,
            'status' => $request->status,
            'total' => $request->total,
        ]);

        foreach ($request->items as $item) {
            $obat = \App\Models\Obat::findOrFail($item['obat_id']);
            $qty = (int) $item['qty'];
            $total = $obat->harga * $qty;

            $pesanan->items()->create([
                'obat_id' => $obat->id,
                'qty' => $qty,
                'total' => $total,
            ]);

            // Optional: Kurangi stok obat
            $obat->decrement('stok', $qty);
        }

        return redirect()->route('admin.pesanans.index');
    }

    public function edit(Pesanan $pesanan)
    {
        abort_if(Gate::denies('pesanan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profiles = Profile::all();
        $pengajuans = Pengajuan::all();

        $pesanan->load(['profile', 'pengajuan', 'items.obat']);

        return view('admin.pesanans.edit', compact('pesanan', 'profiles', 'pengajuans'));
    }

    public function update(UpdatePesananRequest $request, Pesanan $pesanan)
    {
        // Simpan status lama sebelum update
        $statusSebelumnya = $pesanan->status;

        // Update data pesanan (kecuali items)
        $pesanan->update($request->except('items'));

        // Hapus semua item lama
        $pesanan->items()->delete();

        // Simpan ulang item baru
        foreach ($request->items as $item) {
            $obat = \App\Models\Obat::findOrFail($item['obat_id']);
            $qty = (int) $item['qty'];
            $total = $obat->harga * $qty;

            $pesanan->items()->create([
                'obat_id' => $obat->id,
                'qty' => $qty,
                'total' => $total,
            ]);
        }

        // Cek jika status berubah menjadi "diproses" dan sebelumnya bukan
        if ($pesanan->status === 'diproses' && $statusSebelumnya !== 'diproses') {
            foreach ($pesanan->items as $item) {
                $item->obat->decrement('stok', $item->qty);
            }
        }

        return redirect()->route('admin.pesanans.index');
    }

    public function show(Pesanan $pesanan)
    {
        abort_if(Gate::denies('pesanan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pesanan->load(['profile', 'pengajuan', 'items.obat']);

        return view('admin.pesanans.show', compact('pesanan'));
    }

    public function destroy(Pesanan $pesanan)
    {
        abort_if(Gate::denies('pesanan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pesanan->delete();

        return back();
    }

    public function massDestroy(MassDestroyPesananRequest $request)
    {
        $pesanans = Pesanan::find(request('ids'));

        foreach ($pesanans as $pesanan) {
            $pesanan->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
