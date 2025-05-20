@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pengiriman.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.pengirimans.index') }}">
                {{ trans('global.back_to_list') }}
            </a>

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.pengiriman.fields.id') }}</th>
                        <td>{{ $pengiriman->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengiriman.fields.pengirim_id') }}</th>
                        <td>{{ $pengiriman->pengirim->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengiriman.fields.pesanan_id') }}</th>
                        <td>{{ $pengiriman->pesanan->nomor_pesanan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengiriman.fields.alamat') }}</th>
                        <td>{{ $pengiriman->alamat }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengiriman.fields.jarak') }}</th>
                        <td>{{ $pengiriman->jarak }} km</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengiriman.fields.total') }}</th>
                        <td>{{ $pengiriman->total }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengiriman.fields.status') }}</th>
                        <td>{{ \App\Models\Pengiriman::STATUS_SELECT[$pengiriman->status] ?? $pengiriman->status }}</td>
                    </tr>
                </tbody>
            </table>

            <a class="btn btn-default mt-3" href="{{ route('admin.pengirimans.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
