@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.crmProduct.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crm-products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_image') }}
                        </th>
                        <td>
                            @if($crmProduct->product_image)
                                <a href="{{ $crmProduct->product_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $crmProduct->product_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $crmProduct->product_active ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_name') }}
                        </th>
                        <td>
                            {{ $crmProduct->product_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_code') }}
                        </th>
                        <td>
                            {{ $crmProduct->product_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmProduct.fields.product_category') }}
                        </th>
                        <td>
                            {{ $crmProduct->product_category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmProduct.fields.unit_price') }}
                        </th>
                        <td>
                            {{ $crmProduct->unit_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmProduct.fields.description') }}
                        </th>
                        <td>
                            {!! $crmProduct->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmProduct.fields.created_at') }}
                        </th>
                        <td>
                            {{ $crmProduct->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmProduct.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $crmProduct->updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crm-products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection