<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Obat;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePesananItemRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdatePesananItemRequest;
use App\Http\Requests\MassDestroyPesananItemRequest;

class PesananItemController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pesanan_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pesananitems = PesananItem::with(['obat', 'pesanan'])->get();

        return view('admin.pesananitems.index', compact('pesananitems'));
    }

    public function create()
    {
        abort_if(Gate::denies('pesanan_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $obats = Obat::all();
        $pesanans = Pesanan::all();

        return view('admin.pesananitems.create', compact('obats', 'pesanans'));
    }

    public function store(StorePesananItemRequest $request)
    {
        $pesananitem = PesananItem::create($request->all());

        return redirect()->route('admin.pesananitems.index');
    }

    public function edit(PesananItem $pesananitem)
    {
        abort_if(Gate::denies('pesanan_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $obats = Obat::all();
        $pesanans = Pesanan::all();

        $pesananitem->load(['obat', 'pesanan']);

        return view('admin.pesananitems.edit', compact('pesananitem', 'obats', 'pesanans'));
    }

    public function update(UpdatePesananItemRequest $request, PesananItem $pesananitem)
    {
        $pesananitem->update($request->all());

        return redirect()->route('admin.pesananitems.index');
    }

    public function show(PesananItem $pesananitem)
    {
        abort_if(Gate::denies('pesanan_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pesananitem->load(['obat', 'pesanan']);

        return view('admin.pesananitems.show', compact('pesananitem'));
    }

    public function destroy(PesananItem $pesananitem)
    {
        abort_if(Gate::denies('pesanan_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pesananitem->delete();

        return back();
    }

    public function massDestroy(MassDestroyPesananItemRequest $request)
    {
        $pesananitems = PesananItem::find(request('ids'));

        foreach ($pesananitems as $pesananitem) {
            $pesananitem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
