@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.profile.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.profiles.update', [$profile->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="user_id">{{ trans('cruds.profile.fields.user_id') }}</label>
                <select class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    <option value disabled {{ old('user_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $profile->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name ?? $user->email }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.user_id_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="nama_lengkap">{{ trans('cruds.profile.fields.nama_lengkap') }}</label>
                <input class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}" type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $profile->nama_lengkap) }}" required>
                @if($errors->has('nama_lengkap'))
                    <div class="invalid-feedback">{{ $errors->first('nama_lengkap') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.nama_lengkap_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="nomor_telepon">{{ trans('cruds.profile.fields.nomor_telepon') }}</label>
                <input class="form-control {{ $errors->has('nomor_telepon') ? 'is-invalid' : '' }}" type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $profile->nomor_telepon) }}">
                @if($errors->has('nomor_telepon'))
                    <div class="invalid-feedback">{{ $errors->first('nomor_telepon') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.nomor_telepon_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">{{ trans('cruds.profile.fields.jenis_kelamin') }}</label>
                <select class="form-control {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}" name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value disabled {{ old('jenis_kelamin', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Profile::JENIS_KELAMIN_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('jenis_kelamin', $profile->jenis_kelamin) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('jenis_kelamin'))
                    <div class="invalid-feedback">{{ $errors->first('jenis_kelamin') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.jenis_kelamin_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">{{ trans('cruds.profile.fields.tanggal_lahir') }}</label>
                <input class="form-control date {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}" type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $profile->tanggal_lahir) }}">
                @if($errors->has('tanggal_lahir'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_lahir') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.tanggal_lahir_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="image">{{ trans('cruds.profile.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone"></div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.image_helper') }}</span>
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
        url: '{{ route('admin.profiles.storeMedia') }}',
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
@if(isset($profile) && $profile->image)
          var file = {!! json_encode($profile->image) !!}
              this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
          this.options.maxFiles = this.options.maxFiles - 1
@endif
        },
        error: function (file, response) {
            var message = typeof response === 'string' ? response : (response.errors.file || response)
            file.previewElement.classList.add('dz-error')
            let nodes = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            nodes.forEach(node => node.textContent = message)
        }
    }
</script>
@endsection
