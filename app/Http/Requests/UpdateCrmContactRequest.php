<?php

namespace App\Http\Requests;

use App\Models\CrmContact;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCrmContactRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('crm_contact_edit');
    }

    public function rules()
    {
        return [
            'company' => [
                'string',
                'nullable',
            ],
            'contact_first_name' => [
                'string',
                'required',
            ],
            'contact_last_name' => [
                'string',
                'nullable',
            ],
            'contact_phone_1' => [
                'string',
                'nullable',
            ],
            'contact_phone_2' => [
                'string',
                'nullable',
            ],
            'contact_email' => [
                'string',
                'nullable',
            ],
            'contact_address' => [
                'string',
                'nullable',
            ],
            'contact_description' => [
                'string',
                'nullable',
            ],
        ];
    }
}
