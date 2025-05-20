@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pengirim.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.pengirims.index') }}">
                {{ trans('global.back_to_list') }}
            </a>

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.pengirim.fields.id') }}</th>
                        <td>{{ $pengirim->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengirim.fields.name') }}</th>
                        <td>{{ $pengirim->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengirim.fields.nomor_telepon') }}</th>
                        <td>{{ $pengirim->nomor_telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengirim.fields.email') }}</th>
                        <td>{{ $pengirim->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengirim.fields.jenis_kelamin') }}</th>
                        <td>{{ \App\Models\Pengirim::JENIS_KELAMIN_SELECT[$pengirim->jenis_kelamin] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengirim.fields.jenis_kendaraan') }}</th>
                        <td>{{ $pengirim->jenis_kendaraan ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            <a class="btn btn-default mt-3" href="{{ route('admin.pengirims.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
