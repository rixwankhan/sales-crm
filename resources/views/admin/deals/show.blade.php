@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.deal.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.id') }}
                        </th>
                        <td>
                            {{ $deal->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.deal_name') }}
                        </th>
                        <td>
                            {{ $deal->deal_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.contact_name') }}
                        </th>
                        <td>
                            {{ $deal->contact_name->contact_first_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.source') }}
                        </th>
                        <td>
                            {{ $deal->source->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.stage') }}
                        </th>
                        <td>
                            {{ $deal->stage->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.amount') }}
                        </th>
                        <td>
                            {{ $deal->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.closing_date') }}
                        </th>
                        <td>
                            {{ $deal->closing_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.description') }}
                        </th>
                        <td>
                            {!! $deal->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.attachments') }}
                        </th>
                        <td>
                            @foreach($deal->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.products') }}
                        </th>
                        <td>
                            @foreach($deal->products as $key => $products)
                                <span class="label label-info">{{ $products->product_name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.created_at') }}
                        </th>
                        <td>
                            {{ $deal->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deal.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $deal->updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection