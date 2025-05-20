@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.pengajuan.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.pengajuans.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="profile_id">{{ trans('cruds.pengajuan.fields.profile_id') }}</label>
                <select class="form-control {{ $errors->has('profile_id') ? 'is-invalid' : '' }}" name="profile_id" id="profile_id" required>
                    <option value disabled {{ old('profile_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($profiles as $profile)
                        <option value="{{ $profile->id }}" {{ old('profile_id') == $profile->id ? 'selected' : '' }}>
                            {{ $profile->nama_lengkap ?? $profile->user->name ?? '' }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('profile_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profile_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pengajuan.fields.profile_id_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="nomor_pengajuan">{{ trans('cruds.pengajuan.fields.nomor_pengajuan') }}</label>
                <input class="form-control {{ $errors->has('nomor_pengajuan') ? 'is-invalid' : '' }}" type="text" name="nomor_pengajuan" id="nomor_pengajuan" value="{{ old('nomor_pengajuan', $newNomorPengajuan) }}" readonly>
                @if($errors->has('nomor_pengajuan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nomor_pengajuan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pengajuan.fields.nomor_pengajuan_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="catatan">{{ trans('cruds.pengajuan.fields.catatan') }}</label>
                <textarea class="form-control {{ $errors->has('catatan') ? 'is-invalid' : '' }}" name="catatan" id="catatan">{{ old('catatan') }}</textarea>
                @if($errors->has('catatan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('catatan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pengajuan.fields.catatan_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="alamat">{{ trans('cruds.pengajuan.fields.alamat') }}</label>
                <textarea class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}" name="alamat" id="alamat" required>{{ old('alamat') }}</textarea>
                @if($errors->has('alamat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alamat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pengajuan.fields.alamat_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="jarak">{{ trans('cruds.pengajuan.fields.jarak') }}</label>
                <input class="form-control {{ $errors->has('jarak') ? 'is-invalid' : '' }}" type="number" name="jarak" id="jarak" value="{{ old('jarak') }}" step="0.01" required>
                @if($errors->has('jarak'))
                    <div class="invalid-feedback">
                        {{ $errors->first('jarak') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pengajuan.fields.jarak_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="total">{{ trans('cruds.pengajuan.fields.total') }}</label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" name="total" id="total" value="{{ old('total') }}" step="0.01" required>
                @if($errors->has('total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pengajuan.fields.total_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="status">{{ trans('cruds.pengajuan.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Pengajuan::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.pengajuan.fields.status_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="image">{{ trans('cruds.pengajuan.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone"></div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.pengajuan.fields.image_helper') }}</span>
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
    url: '{{ route('admin.pengajuans.storeMedia') }}',
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
@if(isset($pengajuan) && $pengajuan->image)
      var file = {!! json_encode($pengajuan->image) !!}
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
