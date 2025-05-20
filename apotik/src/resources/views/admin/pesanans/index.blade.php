@extends('layouts.admin')
@section('content')
@can('pesanan_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.pesanans.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.pesanan.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.pesanan.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Pesanan">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.pesanan.fields.id') }}</th>
                        <th>{{ trans('cruds.pesanan.fields.nomor_pesanan') }}</th>
                        <th>{{ trans('cruds.pesanan.fields.pesanan') }}</th>
                        <th>{{ trans('cruds.pesanan.fields.profile_id') }}</th>
                        <th>{{ trans('cruds.pesanan.fields.pengajuan_id') }}</th>
                        <th>{{ trans('cruds.pesanan.fields.total') }}</th>
                        <th>{{ trans('cruds.pesanan.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanans as $pesanan)
                        <tr data-entry-id="{{ $pesanan->id }}">
                            <td></td>
                            <td>{{ $pesanan->id ?? '' }}</td>
                            <td>{{ $pesanan->nomor_pesanan ?? '' }}</td>
                            <td>
                                @foreach($pesanan->items as $item)
                                    <div>
                                        {{ $item->obat->nama_obat ?? 'Produk dihapus' }} (x{{ $item->qty }}) = Rp{{ number_format($item->total, 0, ',', '.') }}
                                    </div>
                                @endforeach
                            </td>
                            <td>{{ $pesanan->profile->nama_lengkap ?? '' }}</td>
                            <td>{{ $pesanan->pengajuan->alamat ?? '' }}</td>
                            <td>{{ number_format($pesanan->total, 2, ',', '.') ?? '' }}</td>
                            <td>{{ App\Models\Pesanan::STATUS_SELECT[$pesanan->status] ?? '' }}</td>
                            <td>
                                @can('pesanan_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.pesanans.show', $pesanan->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('pesanan_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pesanans.edit', $pesanan->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('pesanan_delete')
                                    <form action="{{ route('admin.pesanans.destroy', $pesanan->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        @can('pesanan_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.pesanans.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')
                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: {'x-csrf-token': _token},
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }
                    }).done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[1, 'desc']],
            pageLength: 25,
        });

        let table = $('.datatable-Pesanan:not(.ajaxTable)').DataTable({ buttons: dtButtons })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
