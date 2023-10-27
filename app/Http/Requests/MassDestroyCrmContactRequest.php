<?php

namespace App\Http\Requests;

use App\Models\CrmContact;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCrmContactRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('crm_contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:crm_contacts,id',
        ];
    }
}
