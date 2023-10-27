<?php

namespace App\Http\Requests;

use App\Models\CrmProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCrmProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('crm_product_edit');
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
