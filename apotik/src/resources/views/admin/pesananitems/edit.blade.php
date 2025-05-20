@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.pesananitem.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.pesananitems.update', [$pesananitem->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="obat_id">{{ trans('cruds.pesananitem.fields.obat_id') }}</label>
                <select class="form-control {{ $errors->has('obat_id') ? 'is-invalid' : '' }}" name="obat_id" id="obat_id" required>
                    <option value disabled {{ old('obat_id', $pesananitem->obat_id) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" {{ old('obat_id', $pesananitem->obat_id) == $obat->id ? 'selected' : '' }}>
                            {{ $obat->nama_obat ?? 'ID: ' . $obat->id }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('obat_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('obat_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pesananitem.fields.obat_id_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="pesanan_id">{{ trans('cruds.pesananitem.fields.pesanan_id') }}</label>
                <select class="form-control {{ $errors->has('pesanan_id') ? 'is-invalid' : '' }}" name="pesanan_id" id="pesanan_id" required>
                    <option value disabled {{ old('pesanan_id', $pesananitem->pesanan_id) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($pesanans as $pesanan)
                        <option value="{{ $pesanan->id }}" {{ old('pesanan_id', $pesananitem->pesanan_id) == $pesanan->id ? 'selected' : '' }}>
                            {{ $pesanan->name ?? 'ID: ' . $pesanan->id }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('pesanan_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pesanan_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pesananitem.fields.pesanan_id_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="qty">{{ trans('cruds.pesananitem.fields.qty') }}</label>
                <input class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="number" name="qty" id="qty" value="{{ old('qty', $pesananitem->qty) }}" min="1" step="1" required>
                @if($errors->has('qty'))
                    <div class="invalid-feedback">{{ $errors->first('qty') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.pesananitem.fields.qty_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="total">{{ trans('cruds.pesananitem.fields.total') }}</label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" name="total" id="total" value="{{ old('total', $pesananitem->total) }}" step="0.01" required>
                @if($errors->has('total'))
                    <div class="invalid-feedback">{{ $errors->first('total') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.pesananitem.fields.total_helper') }}</span>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
