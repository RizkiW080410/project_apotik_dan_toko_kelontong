@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pesanan.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.pesanans.index') }}">
                {{ trans('global.back_to_list') }}
            </a>

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.pesanan.fields.id') }}</th>
                        <td>{{ $pesanan->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pesanan.fields.nomor_pesanan') }}</th>
                        <td>{{ $pesanan->nomor_pesanan }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pesanan.fields.profile_id') }}</th>
                        <td>{{ $pesanan->profile->nama_lengkap ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pesanan.fields.pengajuan_id') }}</th>
                        <td>{{ $pesanan->pengajuan->alamat ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pesanan.fields.total') }}</th>
                        <td>{{ number_format($pesanan->total, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pesanan.fields.status') }}</th>
                        <td>{{ App\Models\Pesanan::STATUS_SELECT[$pesanan->status] ?? '' }}</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mt-4">Detail Produk</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan->items as $item)
                        <tr>
                            <td>{{ $item->obat->nama_obat ?? 'Produk dihapus' }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>Rp{{ number_format($item->obat->harga ?? 0, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a class="btn btn-default mt-3" href="{{ route('admin.pesanans.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
