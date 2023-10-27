<?php

namespace App\Http\Requests;

use App\Models\CrmProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCrmProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('crm_product_create');
    }

    public function rules()
    {
        return [
            'product_name' => [
                'string',
                'required',
            ],
            'product_code' => [
                'string',
                'nullable',
            ],
        ];
    }
}
