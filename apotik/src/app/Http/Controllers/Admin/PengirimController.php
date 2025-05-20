<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Pengirim;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengirimRequest;
use App\Http\Requests\UpdatePengirimRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyPengirimRequest;

class PengirimController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pengirim_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengirims = Pengirim::all();

        return view('admin.pengirims.index', compact('pengirims'));
    }

    public function create()
    {
        abort_if(Gate::denies('pengirim_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pengirims.create');
    }

    public function store(StorePengirimRequest $request)
    {
        $pengirim = Pengirim::create($request->all());

        return redirect()->route('admin.pengirims.index');
    }

    public function edit(Pengirim $pengirim)
    {
        abort_if(Gate::denies('pengirim_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pengirims.edit', compact('pengirim'));
    }

    public function update(UpdatePengirimRequest $request, Pengirim $pengirim)
    {
        $pengirim->update($request->all());

        return redirect()->route('admin.pengirims.index');
    }

    public function show(Pengirim $pengirim)
    {
        abort_if(Gate::denies('pengirim_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pengirims.show', compact('pengirim'));
    }

    public function destroy(Pengirim $pengirim)
    {
        abort_if(Gate::denies('pengirim_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengirim->delete();

        return back();
    }

    public function massDestroy(MassDestroyPengirimRequest $request)
    {
        $pengirims = Pengirim::find(request('ids'));

        foreach ($pengirims as $pengirim) {
            $pengirim->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
