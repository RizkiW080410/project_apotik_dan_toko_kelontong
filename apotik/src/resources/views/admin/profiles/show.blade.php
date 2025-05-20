@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.profile.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.profiles.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.profile.fields.id') }}</th>
                        <td>{{ $profile->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.profile.fields.image') }}</th>
                        <td>
                            @if($profile->image)
                                <a href="{{ $profile->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $profile->image->getUrl('thumb') }}" alt="{{ $profile->nama_lengkap }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.profile.fields.user') }}</th>
                        <td>{{ $profile->user->name ?? $profile->user->email ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.profile.fields.nama_lengkap') }}</th>
                        <td>{{ $profile->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.profile.fields.nomor_telepon') }}</th>
                        <td>{{ $profile->nomor_telepon }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.profile.fields.jenis_kelamin') }}</th>
                        <td>{{ App\Models\Profile::JENIS_KELAMIN_SELECT[$profile->jenis_kelamin] ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.profile.fields.tanggal_lahir') }}</th>
                        <td>{{ $profile->tanggal_lahir }}</td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-default mt-3" href="{{ route('admin.profiles.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
