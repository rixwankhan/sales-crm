<?php

namespace App\Http\Requests;

use App\Models\DealSource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDealSourceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('deal_source_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
