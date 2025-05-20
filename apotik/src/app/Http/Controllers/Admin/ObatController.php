<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Obat;
use App\Models\Jenis;
use App\Models\Golongan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreObatRequest;
use App\Http\Requests\UpdateObatRequest;
use App\Http\Requests\MassDestroyObatRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ObatController extends Controller
{
    use MediaUploadingTrait;

    private function generateKodeObat()
    {
        $latest = \App\Models\Obat::where('kode_obat', 'LIKE', 'OBT-%')
            ->get()
            ->map(function ($item) {
                if (preg_match('/OBT-(\d+)/', $item->kode_obat, $match)) {
                    return (int) $match[1];
                }
                return 0;
            })
            ->max();

        $next = $latest + 1;

        return 'OBT-' . str_pad($next, 5, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        abort_if(Gate::denies('obat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $obats = Obat::with(['jenis', 'golongan', 'media'])->get();

        return view('admin.obats.index', compact('obats'));
    }

    public function create()
    {
        abort_if(Gate::denies('obat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jenis = Jenis::all();
        $golongan = Golongan::all();

        $kodeObatBaru = $this->generateKodeObat();
        
        return view('admin.obats.create', compact('jenis', 'golongan', 'kodeObatBaru'));
    }

    public function store(StoreObatRequest $request)
    {
        $kodeObatBaru = $this->generateKodeObat();

        $obat = Obat::create(array_merge(
            $request->except('kode_obat'),
            ['kode_obat' => $kodeObatBaru]
        ));

        if ($request->input('image', false)) {
            $obat->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $obat->id]);
        }

        return redirect()->route('admin.obats.index');
    }

    public function edit(Obat $obat)
    {
        abort_if(Gate::denies('obat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $obat->load(['jenis', 'golongan']);

        $jenis = Jenis::all();
        $golongan = Golongan::all();

        return view('admin.obats.edit', compact('obat', 'jenis', 'golongan'));
    }

    public function update(UpdateObatRequest $request, Obat $obat)
    {
        $obat->update($request->all());

        if ($request->input('image', false)) {
            if (! $obat->image || $request->input('image') !== $obat->image->file_name) {
                if ($obat->image) {
                    $obat->image->delete();
                }
                $obat->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($obat->image) {
            $obat->image->delete();
        }

        return redirect()->route('admin.obats.index');
    }

    public function show(Obat $obat)
    {
        abort_if(Gate::denies('obat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $obat->load(['jenis', 'golongan', 'media']);

        return view('admin.obats.show', compact('obat'));
    }

    public function destroy(Obat $obat)
    {
        abort_if(Gate::denies('obat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $obat->delete();

        return back();
    }

    public function massDestroy(MassDestroyObatRequest $request)
    {
        $obats = Obat::find(request('ids'));

        foreach ($obats as $obat) {
            $obat->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('obat_create') && Gate::denies('obat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Obat();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
