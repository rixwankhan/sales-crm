@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.crmContact.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crm-contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.crmContact.fields.company') }}
                        </th>
                        <td>
                            {{ $crmContact->company }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_first_name') }}
                        </th>
                        <td>
                            {{ $crmContact->contact_first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_last_name') }}
                        </th>
                        <td>
                            {{ $crmContact->contact_last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_phone_1') }}
                        </th>
                        <td>
                            {{ $crmContact->contact_phone_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_phone_2') }}
                        </th>
                        <td>
                            {{ $crmContact->contact_phone_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_email') }}
                        </th>
                        <td>
                            {{ $crmContact->contact_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_address') }}
                        </th>
                        <td>
                            {{ $crmContact->contact_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmContact.fields.contact_description') }}
                        </th>
                        <td>
                            {{ $crmContact->contact_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmContact.fields.created_at') }}
                        </th>
                        <td>
                            {{ $crmContact->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crm-contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection