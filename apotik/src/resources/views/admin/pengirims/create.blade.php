@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.pengirim.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.pengirims.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">{{ trans('cruds.pengirim.fields.name') }} <span class="text-danger">*</span></label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengirim.fields.name_helper') }}</small>
            </div>

            <div class="form-group">
                <label for="nomor_telepon">{{ trans('cruds.pengirim.fields.nomor_telepon') }}</label>
                <input class="form-control {{ $errors->has('nomor_telepon') ? 'is-invalid' : '' }}" type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}">
                @if($errors->has('nomor_telepon'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nomor_telepon') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengirim.fields.nomor_telepon_helper') }}</small>
            </div>

            <div class="form-group">
                <label for="email">{{ trans('cruds.pengirim.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengirim.fields.email_helper') }}</small>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">{{ trans('cruds.pengirim.fields.jenis_kelamin') }}</label>
                <select class="form-control {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}" name="jenis_kelamin" id="jenis_kelamin">
                    <option value disabled {{ old('jenis_kelamin', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(\App\Models\Pengirim::JENIS_KELAMIN_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('jenis_kelamin') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('jenis_kelamin'))
                    <div class="invalid-feedback">
                        {{ $errors->first('jenis_kelamin') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengirim.fields.jenis_kelamin_helper') }}</small>
            </div>

            <div class="form-group">
                <label for="jenis_kendaraan">{{ trans('cruds.pengirim.fields.jenis_kendaraan') }}</label>
                <input class="form-control {{ $errors->has('jenis_kendaraan') ? 'is-invalid' : '' }}" type="text" name="jenis_kendaraan" id="jenis_kendaraan" value="{{ old('jenis_kendaraan') }}">
                @if($errors->has('jenis_kendaraan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('jenis_kendaraan') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengirim.fields.jenis_kendaraan_helper') }}</small>
            </div>

            <div class="form-group mt-3">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
