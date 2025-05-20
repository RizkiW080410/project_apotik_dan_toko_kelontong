<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengajuanRequest;
use App\Http\Requests\UpdatePengajuanRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyPengajuanRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\Profile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PengajuanController extends Controller
{
    use MediaUploadingTrait;

    private function generateNomorPengajuan()
    {
        $latest = \App\Models\Pengajuan::where('nomor_pengajuan', 'LIKE', 'PGJ-%')
            ->get()
            ->map(function ($item) {
                if (preg_match('/PGJ-(\d+)/', $item->nomor_pengajuan, $match)) {
                    return (int) $match[1];
                }
                return 0;
            })
            ->max();

        $next = $latest + 1;

        return 'PGJ-' . str_pad($next, 5, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        abort_if(Gate::denies('pengajuan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengajuans = Pengajuan::with(['profile', 'pesanans', 'media'])->get();

        return view('admin.pengajuans.index', compact('pengajuans'));
    }

    public function create()
    {
        abort_if(Gate::denies('pengajuan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profiles = Profile::all();

        $newNomorPengajuan = $this->generateNomorPengajuan();

        return view('admin.pengajuans.create', compact('profiles', 'newNomorPengajuan'));
    }

    public function store(StorePengajuanRequest $request)
    {
        $nomorPengajuanBaru = $this->generateNomorPengajuan();

        $pengajuan = Pengajuan::create(array_merge(
            $request->except('nomor_pengajuan'),
            ['nomor_pengajuan' => $nomorPengajuanBaru]
        ));

        if ($request->input('image', false)) {
            $pengajuan->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $pengajuan->id]);
        }

        return redirect()->route('admin.pengajuans.index');
    }

    public function edit(Pengajuan $pengajuan)
    {
        abort_if(Gate::denies('pengajuan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengajuan->load(['profile', 'pesanans']);

        $profiles = Profile::all();

        return view('admin.pengajuans.edit', compact('pengajuan', 'profiles'));
    }

    public function update(UpdatePengajuanRequest $request, Pengajuan $pengajuan)
    {
        $pengajuan->update($request->all());

        if ($request->input('image', false)) {
            if (! $pengajuan->image || $request->input('image') !== $pengajuan->image->file_name) {
                if ($pengajuan->image) {
                    $pengajuan->image->delete();
                }
                $pengajuan->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($pengajuan->image) {
            $pengajuan->image->delete();
        }

        return redirect()->route('admin.pengajuans.index');
    }

    public function show(Pengajuan $pengajuan)
    {
        abort_if(Gate::denies('pengajuan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengajuan->load(['profile', 'pesanans', 'media']);

        return view('admin.pengajuans.show', compact('pengajuan'));
    }

    public function destroy(Pengajuan $pengajuan)
    {
        abort_if(Gate::denies('pengajuan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengajuan->delete();

        return back();
    }

    public function massDestroy(MassDestroyPengajuanRequest $request)
    {
        $pengajuans = Pengajuan::find(request('ids'));

        foreach ($pengajuans as $pengajuan) {
            $pengajuan->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('pengajuan_create') && Gate::denies('pengajuan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Pengajuan();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
