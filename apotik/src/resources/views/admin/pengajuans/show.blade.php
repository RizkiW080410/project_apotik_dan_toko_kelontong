@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pengajuan.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.pengajuans.index') }}">
                {{ trans('global.back_to_list') }}
            </a>

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.pengajuan.fields.id') }}</th>
                        <td>{{ $pengajuan->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengajuan.fields.image') }}</th>
                        <td>
                            @if($pengajuan->image)
                                <a href="{{ $pengajuan->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $pengajuan->image->getUrl('thumb') }}" alt="{{ $pengajuan->nomor_pengajuan }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengajuan.fields.profile_id') }}</th>
                        <td>{{ $pengajuan->profile->nama_lengkap ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengajuan.fields.nomor_pengajuan') }}</th>
                        <td>{{ $pengajuan->nomor_pengajuan }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengajuan.fields.catatan') }}</th>
                        <td>{!! nl2br(e($pengajuan->catatan)) !!}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengajuan.fields.alamat') }}</th>
                        <td>{!! nl2br(e($pengajuan->alamat)) !!}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengajuan.fields.jarak') }}</th>
                        <td>{{ $pengajuan->jarak }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengajuan.fields.total') }}</th>
                        <td>{{ number_format($pengajuan->total, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengajuan.fields.status') }}</th>
                        <td>{{ App\Models\Pengajuan::STATUS_SELECT[$pengajuan->status] ?? '' }}</td>
                    </tr>
                </tbody>
            </table>

            <a class="btn btn-default mt-3" href="{{ route('admin.pengajuans.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
