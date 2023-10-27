<?php

namespace App\Http\Requests;

use App\Models\DealStage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDealStageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('deal_stage_create');
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
