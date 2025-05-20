@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.obat.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.obats.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.id') }}</th>
                        <td>{{ $obat->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.image') }}</th>
                        <td>
                            @if($obat->image)
                                <a href="{{ $obat->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $obat->image->getUrl('thumb') }}" alt="{{ $obat->nama_obat }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.nama_obat') }}</th>
                        <td>{{ $obat->nama_obat }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.jenis_id') }}</th>
                        <td>{{ $obat->jenis->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.golongan_id') }}</th>
                        <td>{{ $obat->golongan->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.kode_obat') }}</th>
                        <td>{{ $obat->kode_obat }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.komposisi') }}</th>
                        <td>{!! nl2br(e($obat->komposisi)) !!}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.dosis') }}</th>
                        <td>{!! nl2br(e($obat->dosis)) !!}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.aturan_pakai') }}</th>
                        <td>{!! nl2br(e($obat->aturan_pakai)) !!}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.nomor_izin_edaar') }}</th>
                        <td>{{ $obat->nomor_izin_edaar }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.tanggal_kadaluarsa') }}</th>
                        <td>{{ $obat->tanggal_kadaluarsa }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.harga') }}</th>
                        <td>{{ number_format($obat->harga, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.stok') }}</th>
                        <td>{{ $obat->stok }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.status_label') }}</th>
                        <td>{{ App\Models\Obat::STATUS_LABEL_SELECT[$obat->status_label] ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.obat.fields.status') }}</th>
                        <td>{{ App\Models\Obat::STATUS_SELECT[$obat->status] ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-default mt-3" href="{{ route('admin.obats.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
