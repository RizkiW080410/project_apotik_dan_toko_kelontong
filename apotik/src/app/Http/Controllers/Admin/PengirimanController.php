<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Pesanan;
use App\Models\Pengirim;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengirimanRequest;
use App\Http\Requests\UpdatePengirimanRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyPengirimanRequest;

class PengirimanController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pengiriman_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengirimans = Pengiriman::with(['pengirim', 'pesanan'])->get();

        return view('admin.pengirimans.index', compact('pengirimans'));
    }

    public function create()
    {
        abort_if(Gate::denies('pengiriman_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengirims = Pengirim::all();
        $pesanans = Pesanan::all();

        return view('admin.pengirimans.create', compact('pengirims', 'pesanans'));
    }

    public function store(StorePengirimanRequest $request)
    {
        $pengiriman = Pengiriman::create($request->all());

        return redirect()->route('admin.pengirimans.index');
    }

    public function edit(Pengiriman $pengiriman)
    {
        abort_if(Gate::denies('pengiriman_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengirims = Pengirim::all();
        $pesanans = Pesanan::all();

        $pengiriman->load(['pengirim', 'pesanan']);

        return view('admin.pengirimans.edit', compact('pengiriman', 'pengirims', 'pesanans'));
    }

    public function update(UpdatePengirimanRequest $request, Pengiriman $pengiriman)
    {
        $pengiriman->update($request->all());

        return redirect()->route('admin.pengirimans.index');
    }

    public function show(Pengiriman $pengiriman)
    {
        abort_if(Gate::denies('pengiriman_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengiriman->load(['pengirim', 'pesanan']);

        return view('admin.pengirimans.show', compact('pengiriman'));
    }

    public function destroy(Pengiriman $pengiriman)
    {
        abort_if(Gate::denies('pengiriman_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengiriman->delete();

        return back();
    }

    public function massDestroy(MassDestroyPengirimanRequest $request)
    {
        $pengirimans = Pengiriman::find(request('ids'));

        foreach ($pengirimans as $pengiriman) {
            $pengiriman->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
