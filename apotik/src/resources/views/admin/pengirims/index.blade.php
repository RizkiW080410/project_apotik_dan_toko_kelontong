@extends('layouts.admin')
@section('content')
@can('pengirim_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.pengirims.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.pengirim.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.pengirim.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Pengirim">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.pengirim.fields.id') }}</th>
                        <th>{{ trans('cruds.pengirim.fields.name') }}</th>
                        <th>{{ trans('cruds.pengirim.fields.nomor_telepon') }}</th>
                        <th>{{ trans('cruds.pengirim.fields.email') }}</th>
                        <th>{{ trans('cruds.pengirim.fields.jenis_kelamin') }}</th>
                        <th>{{ trans('cruds.pengirim.fields.jenis_kendaraan') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengirims as $pengirim)
                        <tr data-entry-id="{{ $pengirim->id }}">
                            <td></td>
                            <td>{{ $pengirim->id ?? '' }}</td>
                            <td>{{ $pengirim->name ?? '' }}</td>
                            <td>{{ $pengirim->nomor_telepon ?? '' }}</td>
                            <td>{{ $pengirim->email ?? '' }}</td>
                            <td>{{ \App\Models\Pengirim::JENIS_KELAMIN_SELECT[$pengirim->jenis_kelamin] ?? '' }}</td>
                            <td>{{ $pengirim->jenis_kendaraan ?? '' }}</td>
                            <td>
                                @can('pengirim_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.pengirims.show', $pengirim->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('pengirim_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pengirims.edit', $pengirim->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('pengirim_delete')
                                    <form action="{{ route('admin.pengirims.destroy', $pengirim->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
        @can('pengirim_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.pengirims.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id');
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}');
                        return;
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': '{{ csrf_token() }}'},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        }).done(function () { location.reload(); });
                    }
                }
            };
            dtButtons.push(deleteButton);
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]],
            pageLength: 25,
        });
        let table = $('.datatable-Pengirim:not(.ajaxTable)').DataTable({ buttons: dtButtons });
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });
</script>
@endsection
