@extends('layouts.admin')
@section('content')
@can('obat_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.obats.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.obat.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.obat.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Obat">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.obat.fields.id') }}</th>
                        <th>{{ trans('cruds.obat.fields.image') }}</th>
                        <th>{{ trans('cruds.obat.fields.nama_obat') }}</th>
                        <th>{{ trans('cruds.obat.fields.jenis_id') }}</th>
                        <th>{{ trans('cruds.obat.fields.golongan_id') }}</th>
                        <th>{{ trans('cruds.obat.fields.kode_obat') }}</th>
                        <th>{{ trans('cruds.obat.fields.komposisi') }}</th>
                        <th>{{ trans('cruds.obat.fields.dosis') }}</th>
                        <th>{{ trans('cruds.obat.fields.aturan_pakai') }}</th>
                        <th>{{ trans('cruds.obat.fields.nomor_izin_edaar') }}</th>
                        <th>{{ trans('cruds.obat.fields.tanggal_kadaluarsa') }}</th>
                        <th>{{ trans('cruds.obat.fields.harga') }}</th>
                        <th>{{ trans('cruds.obat.fields.stok') }}</th>
                        <th>{{ trans('cruds.obat.fields.status_label') }}</th>
                        <th>{{ trans('cruds.obat.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obats as $obat)
                        <tr data-entry-id="{{ $obat->id }}">
                            <td></td>
                            <td>{{ $obat->id ?? '' }}</td>
                            <td>
                                @if($obat->image)
                                    <a href="{{ $obat->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $obat->image->getUrl('thumb') }}" alt="{{ $obat->nama_obat }}" />
                                    </a>
                                @endif
                            </td>
                            <td>{{ $obat->nama_obat ?? '' }}</td>
                            <td>{{ $obat->jenis->name ?? '' }}</td>
                            <td>{{ $obat->golongan->name ?? '' }}</td>
                            <td>{{ $obat->kode_obat ?? '' }}</td>
                            <td>{{ Str::limit($obat->komposisi, 30) ?? '' }}</td>
                            <td>{{ Str::limit($obat->dosis, 30) ?? '' }}</td>
                            <td>{{ Str::limit($obat->aturan_pakai, 30) ?? '' }}</td>
                            <td>{{ $obat->nomor_izin_edaar ?? '' }}</td>
                            <td>{{ $obat->tanggal_kadaluarsa ?? '' }}</td>
                            <td>{{ number_format($obat->harga, 2, ',', '.') ?? '' }}</td>
                            <td>{{ $obat->stok ?? '' }}</td>
                            <td>{{ App\Models\Obat::STATUS_LABEL_SELECT[$obat->status_label] ?? '' }}</td>
                            <td>{{ App\Models\Obat::STATUS_SELECT[$obat->status] ?? '' }}</td>
                            <td>
                                @can('obat_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.obats.show', $obat->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('obat_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.obats.edit', $obat->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('obat_delete')
                                    <form action="{{ route('admin.obats.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        @can('obat_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.obats.massDestroy') }}",
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

        let table = $('.datatable-Obat:not(.ajaxTable)').DataTable({ buttons: dtButtons })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
