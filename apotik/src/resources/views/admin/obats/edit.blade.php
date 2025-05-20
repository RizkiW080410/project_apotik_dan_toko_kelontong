@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.obat.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.obats.update", [$obat->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="image">{{ trans('cruds.obat.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nama_obat">{{ trans('cruds.obat.fields.nama_obat') }}</label>
                <input class="form-control {{ $errors->has('nama_obat') ? 'is-invalid' : '' }}" type="text" name="nama_obat" id="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}">
                @if($errors->has('nama_obat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama_obat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.nama_obat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="jenis_id">{{ trans('cruds.obat.fields.jenis_id') }}</label>
                <select class="form-control {{ $errors->has('jenis_id') ? 'is-invalid' : '' }}" name="jenis_id" id="jenis_id" required>
                    <option value disabled {{ old('jenis_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($jenis as $entry)
                        <option value="{{ $entry->id }}" {{ old('jenis_id', $obat->jenis_id) == $entry->id ? 'selected' : '' }}>{{ $entry->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('jenis_id'))
                    <div class="invalid-feedback">{{ $errors->first('jenis_id') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.jenis_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="golongan_id">{{ trans('cruds.obat.fields.golongan_id') }}</label>
                <select class="form-control {{ $errors->has('golongan_id') ? 'is-invalid' : '' }}" name="golongan_id" id="golongan_id" required>
                    <option value disabled {{ old('golongan_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($golongan as $entry)
                        <option value="{{ $entry->id }}" {{ old('golongan_id', $obat->golongan_id) == $entry->id ? 'selected' : '' }}>{{ $entry->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('golongan_id'))
                    <div class="invalid-feedback">{{ $errors->first('golongan_id') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.golongan_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="kode_obat">{{ trans('cruds.obat.fields.kode_obat') }}</label>
                <input class="form-control {{ $errors->has('kode_obat') ? 'is-invalid' : '' }}" type="text" name="kode_obat" id="kode_obat" value="{{ old('kode_obat', $obat->kode_obat) }}">
                @if($errors->has('kode_obat'))
                    <div class="invalid-feedback">{{ $errors->first('kode_obat') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.kode_obat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="komposisi">{{ trans('cruds.obat.fields.komposisi') }}</label>
                <textarea class="form-control {{ $errors->has('komposisi') ? 'is-invalid' : '' }}" name="komposisi" id="komposisi">{{ old('komposisi', $obat->komposisi) }}</textarea>
                @if($errors->has('komposisi'))
                    <div class="invalid-feedback">{{ $errors->first('komposisi') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.komposisi_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dosis">{{ trans('cruds.obat.fields.dosis') }}</label>
                <textarea class="form-control {{ $errors->has('dosis') ? 'is-invalid' : '' }}" name="dosis" id="dosis">{{ old('dosis', $obat->dosis) }}</textarea>
                @if($errors->has('dosis'))
                    <div class="invalid-feedback">{{ $errors->first('dosis') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.dosis_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="aturan_pakai">{{ trans('cruds.obat.fields.aturan_pakai') }}</label>
                <textarea class="form-control {{ $errors->has('aturan_pakai') ? 'is-invalid' : '' }}" name="aturan_pakai" id="aturan_pakai">{{ old('aturan_pakai', $obat->aturan_pakai) }}</textarea>
                @if($errors->has('aturan_pakai'))
                    <div class="invalid-feedback">{{ $errors->first('aturan_pakai') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.aturan_pakai_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nomor_izin_edaar">{{ trans('cruds.obat.fields.nomor_izin_edaar') }}</label>
                <input class="form-control {{ $errors->has('nomor_izin_edaar') ? 'is-invalid' : '' }}" type="text" name="nomor_izin_edaar" id="nomor_izin_edaar" value="{{ old('nomor_izin_edaar', $obat->nomor_izin_edaar) }}">
                @if($errors->has('nomor_izin_edaar'))
                    <div class="invalid-feedback">{{ $errors->first('nomor_izin_edaar') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.nomor_izin_edaar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tanggal_kadaluarsa">{{ trans('cruds.obat.fields.tanggal_kadaluarsa') }}</label>
                <input class="form-control date {{ $errors->has('tanggal_kadaluarsa') ? 'is-invalid' : '' }}" type="text" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa) }}">
                @if($errors->has('tanggal_kadaluarsa'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_kadaluarsa') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.tanggal_kadaluarsa_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="harga">{{ trans('cruds.obat.fields.harga') }}</label>
                <input class="form-control {{ $errors->has('harga') ? 'is-invalid' : '' }}" type="number" name="harga" id="harga" value="{{ old('harga', $obat->harga) }}" step="0.01">
                @if($errors->has('harga'))
                    <div class="invalid-feedback">{{ $errors->first('harga') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.harga_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="stok">{{ trans('cruds.obat.fields.stok') }}</label>
                <input class="form-control {{ $errors->has('stok') ? 'is-invalid' : '' }}" type="number" name="stok" id="stok" value="{{ old('stok', $obat->stok) }}" step="1">
                @if($errors->has('stok'))
                    <div class="invalid-feedback">{{ $errors->first('stok') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.stok_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_label">{{ trans('cruds.obat.fields.status_label') }}</label>
                <select class="form-control {{ $errors->has('status_label') ? 'is-invalid' : '' }}" name="status_label" id="status_label" required>
                    <option value disabled {{ old('status_label', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Obat::STATUS_LABEL_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status_label', $obat->status_label) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status_label'))
                    <div class="invalid-feedback">{{ $errors->first('status_label') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.status_label_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.obat.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Obat::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $obat->status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.obat.fields.status_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.obats.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($obat) && $obat->image)
      var file = {!! json_encode($obat->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection