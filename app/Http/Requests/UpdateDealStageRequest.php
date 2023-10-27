<?php

namespace App\Http\Requests;

use App\Models\DealStage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDealStageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('deal_stage_edit');
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
