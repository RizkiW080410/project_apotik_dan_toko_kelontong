<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Golongan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGolonganRequest;
use App\Http\Requests\UpdateGolonganRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyGolonganRequest;

class GolonganController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('golongan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $golongans = Golongan::all();

        return view('admin.golongans.index', compact('golongans'));
    }

    public function create()
    {
        abort_if(Gate::denies('golongan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.golongans.create');
    }

    public function store(StoreGolonganRequest $request)
    {
        $golongan = Golongan::create($request->all());

        return redirect()->route('admin.golongans.index');
    }

    public function edit(Golongan $golongan)
    {
        abort_if(Gate::denies('golongan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.golongans.edit', compact('golongan'));
    }

    public function update(UpdateGolonganRequest $request, Golongan $golongan)
    {
        $golongan->update($request->all());

        return redirect()->route('admin.golongans.index');
    }

    public function show(Golongan $golongan)
    {
        abort_if(Gate::denies('golongan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.golongans.show', compact('golongan'));
    }

    public function destroy(Golongan $golongan)
    {
        abort_if(Gate::denies('golongan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $golongan->delete();

        return back();
    }

    public function massDestroy(MassDestroyGolonganRequest $request)
    {
        $golongans = Golongan::find(request('ids'));

        foreach ($golongans as $golongan) {
            $golongan->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
