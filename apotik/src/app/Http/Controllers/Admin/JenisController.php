<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Jenis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJenisRequest;
use App\Http\Requests\UpdateJenisRequest;
use App\Http\Requests\MassDestroyJenisRequest;
use Symfony\Component\HttpFoundation\Response;

class JenisController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('jenis_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jenise = Jenis::all();

        return view('admin.jenise.index', compact('jenise'));
    }

    public function create()
    {
        abort_if(Gate::denies('jenis_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.jenise.create');
    }

    public function store(StoreJenisRequest $request)
    {
        $jenis = Jenis::create($request->all());

        return redirect()->route('admin.jenise.index');
    }

    public function edit(Jenis $jenis)
    {
        abort_if(Gate::denies('jenis_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.jenise.edit', compact('jenis'));
    }

    public function update(UpdateJenisRequest $request, Jenis $jenis)
    {
        $jenis->update($request->all());

        return redirect()->route('admin.jenise.index');
    }

    public function show(Jenis $jenis)
    {
        abort_if(Gate::denies('jenis_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.jenise.show', compact('jenis'));
    }

    public function destroy(Jenis $jenis)
    {
        abort_if(Gate::denies('jenis_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jenis->delete();

        return back();
    }

    public function massDestroy(MassDestroyJenisRequest $request)
    {
        $jenise = Jenis::find(request('ids'));

        foreach ($jenise as $jenis) {
            $jenis->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
