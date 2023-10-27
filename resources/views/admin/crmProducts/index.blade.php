@extends('layouts.admin')
@section('content')
@can('crm_product_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.crm-products.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.crmProduct.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CrmProduct', 'route' => 'admin.crm-products.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.crmProduct.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CrmProduct">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_active') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_category') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmProduct.fields.unit_price') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmProduct.fields.created_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmProduct.fields.updated_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crmProducts as $key => $crmProduct)
                        <tr data-entry-id="{{ $crmProduct->id }}">
                            <td>

                            </td>
                            <td>
                                @if($crmProduct->product_image)
                                    <a href="{{ $crmProduct->product_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $crmProduct->product_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <span style="display:none">{{ $crmProduct->product_active ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $crmProduct->product_active ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $crmProduct->product_name ?? '' }}
                            </td>
                            <td>
                                {{ $crmProduct->product_code ?? '' }}
                            </td>
                            <td>
                                {{ $crmProduct->product_category->name ?? '' }}
                            </td>
                            <td>
                                {{ $crmProduct->unit_price ?? '' }}
                            </td>
                            <td>
                                {{ $crmProduct->created_at ?? '' }}
                            </td>
                            <td>
                                {{ $crmProduct->updated_at ?? '' }}
                            </td>
                            <td>
                                @can('crm_product_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.crm-products.show', $crmProduct->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('crm_product_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.crm-products.edit', $crmProduct->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('crm_product_delete')
                                    <form action="{{ route('admin.crm-products.destroy', $crmProduct->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('crm_product_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.crm-products.massDestroy') }}",
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
    order: [[ 3, 'asc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-CrmProduct:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection