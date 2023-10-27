@extends('layouts.admin')
@section('content')
@can('crm_contact_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.crm-contacts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.crmContact.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CrmContact', 'route' => 'admin.crm-contacts.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.crmContact.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CrmContact">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.crmContact.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_first_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_last_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_phone_1') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_phone_2') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_address') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_description') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmContact.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crmContacts as $key => $crmContact)
                        <tr data-entry-id="{{ $crmContact->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $crmContact->company ?? '' }}
                            </td>
                            <td>
                                {{ $crmContact->contact_first_name ?? '' }}
                            </td>
                            <td>
                                {{ $crmContact->contact_last_name ?? '' }}
                            </td>
                            <td>
                                {{ $crmContact->contact_phone_1 ?? '' }}
                            </td>
                            <td>
                                {{ $crmContact->contact_phone_2 ?? '' }}
                            </td>
                            <td>
                                {{ $crmContact->contact_email ?? '' }}
                            </td>
                            <td>
                                {{ $crmContact->contact_address ?? '' }}
                            </td>
                            <td>
                                {{ $crmContact->contact_description ?? '' }}
                            </td>
                            <td>
                                {{ $crmContact->created_at ?? '' }}
                            </td>
                            <td>
                                @can('crm_contact_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.crm-contacts.show', $crmContact->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('crm_contact_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.crm-contacts.edit', $crmContact->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('crm_contact_delete')
                                    <form action="{{ route('admin.crm-contacts.destroy', $crmContact->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('crm_contact_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.crm-contacts.massDestroy') }}",
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
  let table = $('.datatable-CrmContact:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection