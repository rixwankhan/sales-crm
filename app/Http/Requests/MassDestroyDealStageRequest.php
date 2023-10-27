<?php

namespace App\Http\Requests;

use App\Models\DealStage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDealStageRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('deal_stage_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:deal_stages,id',
        ];
    }
}
