@extends('layouts.admin')
@section('content')
@can('pengajuan_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.pengajuans.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.pengajuan.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.pengajuan.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Pengajuan">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.pengajuan.fields.id') }}</th>
                        <th>{{ trans('cruds.pengajuan.fields.image') }}</th>
                        <th>{{ trans('cruds.pengajuan.fields.profile_id') }}</th>
                        <th>{{ trans('cruds.pengajuan.fields.nomor_pengajuan') }}</th>
                        <th>{{ trans('cruds.pengajuan.fields.catatan') }}</th>
                        <th>{{ trans('cruds.pengajuan.fields.alamat') }}</th>
                        <th>{{ trans('cruds.pengajuan.fields.jarak') }}</th>
                        <th>{{ trans('cruds.pengajuan.fields.total') }}</th>
                        <th>{{ trans('cruds.pengajuan.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuans as $pengajuan)
                        <tr data-entry-id="{{ $pengajuan->id }}">
                            <td></td>
                            <td>{{ $pengajuan->id ?? '' }}</td>
                            <td>
                                @if($pengajuan->image)
                                    <a href="{{ $pengajuan->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $pengajuan->image->getUrl('thumb') }}" alt="{{ $pengajuan->nomor_pengajuan }}" />
                                    </a>
                                @endif
                            </td>
                            <td>{{ $pengajuan->profile->nama_lengkap ?? '' }}</td>
                            <td>{{ $pengajuan->nomor_pengajuan ?? '' }}</td>
                            <td>{{ Str::limit($pengajuan->catatan, 30) ?? '' }}</td>
                            <td>{{ Str::limit($pengajuan->alamat, 30) ?? '' }}</td>
                            <td>{{ $pengajuan->jarak ?? '' }}</td>
                            <td>{{ number_format($pengajuan->total, 2, ',', '.') ?? '' }}</td>
                            <td>{{ App\Models\Pengajuan::STATUS_SELECT[$pengajuan->status] ?? '' }}</td>
                            <td>
                                @can('pengajuan_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.pengajuans.show', $pengajuan->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('pengajuan_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pengajuans.edit', $pengajuan->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('pengajuan_delete')
                                    <form action="{{ route('admin.pengajuans.destroy', $pengajuan->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        @can('pengajuan_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.pengajuans.massDestroy') }}",
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

        let table = $('.datatable-Pengajuan:not(.ajaxTable)').DataTable({ buttons: dtButtons })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
