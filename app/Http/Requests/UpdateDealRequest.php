<?php

namespace App\Http\Requests;

use App\Models\Deal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDealRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('deal_edit');
    }

    public function rules()
    {
        return [
            'deal_name' => [
                'string',
                'required',
            ],
            'stage_id' => [
                'required',
                'integer',
            ],
            'closing_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'attachments' => [
                'array',
            ],
            'products.*' => [
                'integer',
            ],
            'products' => [
                'array',
            ],
        ];
    }
}
