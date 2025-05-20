@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pesananitem.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.pesananitems.index') }}">
                {{ trans('global.back_to_list') }}
            </a>

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.pesananitem.fields.id') }}</th>
                        <td>{{ $pesananitem->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pesananitem.fields.obat_id') }}</th>
                        <td>{{ $pesananitem->obat->nama_obat ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pesananitem.fields.pesanan_id') }}</th>
                        <td>{{ $pesananitem->pesanan->nomor_pesanan ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pesananitem.fields.qty') }}</th>
                        <td>{{ $pesananitem->qty }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pesananitem.fields.total') }}</th>
                        <td>{{ number_format($pesananitem->total, 2, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <a class="btn btn-default mt-3" href="{{ route('admin.pesananitems.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
