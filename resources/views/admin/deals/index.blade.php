@extends('layouts.admin')
@section('content')
@can('deal_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.deals.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.deal.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Deal', 'route' => 'admin.deals.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.deal.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Deal">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.deal_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.contact_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.source') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.stage') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.closing_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.attachments') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.products') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.created_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.deal.fields.updated_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deals as $key => $deal)
                        <tr data-entry-id="{{ $deal->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $deal->id ?? '' }}
                            </td>
                            <td>
                                {{ $deal->deal_name ?? '' }}
                            </td>
                            <td>
                                {{ $deal->contact_name->contact_first_name ?? '' }}
                            </td>
                            <td>
                                {{ $deal->source->name ?? '' }}
                            </td>
                            <td>
                                {{ $deal->stage->name ?? '' }}
                            </td>
                            <td>
                                {{ $deal->amount ?? '' }}
                            </td>
                            <td>
                                {{ $deal->closing_date ?? '' }}
                            </td>
                            <td>
                                @foreach($deal->attachments as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @foreach($deal->products as $key => $item)
                                    <span class="badge badge-info">{{ $item->product_name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $deal->created_at ?? '' }}
                            </td>
                            <td>
                                {{ $deal->updated_at ?? '' }}
                            </td>
                            <td>
                                @can('deal_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.deals.show', $deal->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('deal_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.deals.edit', $deal->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('deal_delete')
                                    <form action="{{ route('admin.deals.destroy', $deal->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
@can('deal_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.deals.massDestroy') }}",
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-Deal:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection