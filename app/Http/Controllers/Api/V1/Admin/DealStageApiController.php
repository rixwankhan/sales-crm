<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDealStageRequest;
use App\Http\Requests\UpdateDealStageRequest;
use App\Http\Resources\Admin\DealStageResource;
use App\Models\DealStage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DealStageApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deal_stage_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealStageResource(DealStage::all());
    }

    public function store(StoreDealStageRequest $request)
    {
        $dealStage = DealStage::create($request->all());

        return (new DealStageResource($dealStage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DealStage $dealStage)
    {
        abort_if(Gate::denies('deal_stage_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealStageResource($dealStage);
    }

    public function update(UpdateDealStageRequest $request, DealStage $dealStage)
    {
        $dealStage->update($request->all());

        return (new DealStageResource($dealStage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DealStage $dealStage)
    {
        abort_if(Gate::denies('deal_stage_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealStage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
