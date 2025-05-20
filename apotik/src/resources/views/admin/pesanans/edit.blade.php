@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.pesanan.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.pesanans.update', [$pesanan->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="profile_id">{{ trans('cruds.pesanan.fields.profile_id') }}</label>
                <select class="form-control {{ $errors->has('profile_id') ? 'is-invalid' : '' }}" name="profile_id" id="profile_id" required>
                    <option value disabled {{ old('profile_id', $pesanan->profile_id) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($profiles as $profile)
                        <option value="{{ $profile->id }}" {{ old('profile_id', $pesanan->profile_id) == $profile->id ? 'selected' : '' }}>
                            {{ $profile->nama_lengkap ?? 'ID: ' . $profile->id }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('profile_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profile_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pesanan.fields.profile_id_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="pengajuan_id">{{ trans('cruds.pesanan.fields.pengajuan_id') }}</label>
                <select class="form-control {{ $errors->has('pengajuan_id') ? 'is-invalid' : '' }}" name="pengajuan_id" id="pengajuan_id">
                    <option value disabled {{ old('pengajuan_id', $pesanan->pengajuan_id) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($pengajuans as $pengajuan)
                        <option value="{{ $pengajuan->id }}" {{ old('pengajuan_id', $pesanan->pengajuan_id) == $pengajuan->id ? 'selected' : '' }}>
                            {{ $pengajuan->alamat ?? 'ID: ' . $pengajuan->id }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('pengajuan_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pengajuan_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pesanan.fields.pengajuan_id_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="nomor_pesanan">{{ trans('cruds.pesanan.fields.nomor_pesanan') }}</label>
                <input class="form-control" type="text" name="nomor_pesanan" id="nomor_pesanan" value="{{ old('nomor_pesanan', $pesanan->nomor_pesanan) }}" readonly>
                @if($errors->has('nomor_pesanan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nomor_pesanan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pesanan.fields.nomor_pesanan_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="total">{{ trans('cruds.pesanan.fields.total') }}</label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" name="total" id="total" value="{{ old('total', $pesanan->total) }}" step="0.01">
                @if($errors->has('total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pesanan.fields.total_helper') }}</span>
            </div>

            <h5>Detail Produk</h5>
            <div id="items-wrapper">
                @foreach($pesanan->items as $index => $item)
                    <div class="item-row row mb-2">
                        <div class="col-md-6">
                            <label>Obat</label>
                            <select name="items[{{ $index }}][obat_id]" class="form-control select-obat" required>
                                <option value="">-- Pilih Obat --</option>
                                @foreach(\App\Models\Obat::all() as $obat)
                                    <option value="{{ $obat->id }}" 
                                        data-harga="{{ $obat->harga }}"
                                        {{ $item->obat_id == $obat->id ? 'selected' : '' }}>
                                        {{ $obat->nama_obat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Qty</label>
                            <input type="number" name="items[{{ $index }}][qty]" class="form-control qty-input" value="{{ $item->qty }}" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label>Total</label>
                            <input type="text" class="form-control total-item" readonly value="{{ number_format($item->total) }}">
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-item">+ Tambah Produk</button>

            <div class="form-group mt-3">
                <label>Total Pesanan</label>
                <input type="text" id="total-harga" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label for="status">{{ trans('cruds.pesanan.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', $pesanan->status) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Pesanan::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $pesanan->status) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pesanan.fields.status_helper') }}</span>
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
let itemIndex = {{ count($pesanan->items) }};

function updateTotals() {
    let grandTotal = 0;
    $('#items-wrapper .item-row').each(function () {
        const harga = $(this).find('.select-obat option:selected').data('harga') || 0;
        const qty = parseInt($(this).find('.qty-input').val()) || 0;
        const total = harga * qty;
        $(this).find('.total-item').val(total.toLocaleString());
        grandTotal += total;
    });
    $('#total-harga').val(grandTotal.toLocaleString());
    $('input[name="total"]').val(grandTotal);
}

$(document).on('change', '.select-obat, .qty-input', updateTotals);

$('#add-item').click(function () {
    const newRow = `
    <div class="item-row row mb-2">
        <div class="col-md-6">
            <select name="items[${itemIndex}][obat_id]" class="form-control select-obat" required>
                <option value="">-- Pilih Obat --</option>
                @foreach(\App\Models\Obat::all() as $obat)
                    <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}">{{ $obat->nama_obat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="items[${itemIndex}][qty]" class="form-control qty-input" value="1" min="1" required>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control total-item" readonly>
        </div>
    </div>`;
    $('#items-wrapper').append(newRow);
    itemIndex++;
    updateTotals();
});

$(document).ready(function () {
    updateTotals();
});
</script>
@endsection

