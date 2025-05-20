@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.pengiriman.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.pengirimans.update', [$pengiriman->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="pengirim_id">{{ trans('cruds.pengiriman.fields.pengirim_id') }} <span class="text-danger">*</span></label>
                <select class="form-control {{ $errors->has('pengirim_id') ? 'is-invalid' : '' }}" name="pengirim_id" id="pengirim_id" required>
                    <option value disabled {{ old('pengirim_id', $pengiriman->pengirim_id) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($pengirims as $pengirim)
                        <option value="{{ $pengirim->id }}" {{ (old('pengirim_id', $pengiriman->pengirim_id) == $pengirim->id) ? 'selected' : '' }}>
                            {{ $pengirim->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('pengirim_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pengirim_id') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengiriman.fields.pengirim_id_helper') }}</small>
            </div>

            <div class="form-group">
                <label for="pesanan_id">{{ trans('cruds.pengiriman.fields.pesanan_id') }} <span class="text-danger">*</span></label>
                <select class="form-control {{ $errors->has('pesanan_id') ? 'is-invalid' : '' }}" name="pesanan_id" id="pesanan_id" required>
                    <option value disabled {{ old('pesanan_id', $pengiriman->pesanan_id) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($pesanans as $pesanan)
                        <option value="{{ $pesanan->id }}" {{ (old('pesanan_id', $pengiriman->pesanan_id) == $pesanan->id) ? 'selected' : '' }}>
                            {{ $pesanan->nomor_pesanan ?? 'Pesanan #' . $pesanan->id }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('pesanan_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pesanan_id') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengiriman.fields.pesanan_id_helper') }}</small>
            </div>

            <div class="form-group">
                <label for="alamat">{{ trans('cruds.pengiriman.fields.alamat') }} <span class="text-danger">*</span></label>
                <textarea class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}" name="alamat" id="alamat" required>{{ old('alamat', $pengiriman->alamat) }}</textarea>
                @if($errors->has('alamat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alamat') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengiriman.fields.alamat_helper') }}</small>
            </div>

            <div class="form-group">
                <label for="jarak">{{ trans('cruds.pengiriman.fields.jarak') }} (km) <span class="text-danger">*</span></label>
                <input class="form-control {{ $errors->has('jarak') ? 'is-invalid' : '' }}" type="number" step="0.01" name="jarak" id="jarak" value="{{ old('jarak', $pengiriman->jarak) }}" required>
                @if($errors->has('jarak'))
                    <div class="invalid-feedback">
                        {{ $errors->first('jarak') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengiriman.fields.jarak_helper') }}</small>
            </div>

            <div class="form-group">
                <label for="total">{{ trans('cruds.pengiriman.fields.total') }} <span class="text-danger">*</span></label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" step="0.01" name="total" id="total" value="{{ old('total', $pengiriman->total) }}" required>
                @if($errors->has('total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengiriman.fields.total_helper') }}</small>
            </div>

            <div class="form-group">
                <label for="status">{{ trans('cruds.pengiriman.fields.status') }} <span class="text-danger">*</span></label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', $pengiriman->status) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(\App\Models\Pengiriman::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (old('status', $pengiriman->status) === $key) ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <small class="form-text text-muted">{{ trans('cruds.pengiriman.fields.status_helper') }}</small>
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
