<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDealSourceRequest;
use App\Http\Requests\UpdateDealSourceRequest;
use App\Http\Resources\Admin\DealSourceResource;
use App\Models\DealSource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DealSourceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deal_source_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealSourceResource(DealSource::all());
    }

    public function store(StoreDealSourceRequest $request)
    {
        $dealSource = DealSource::create($request->all());

        return (new DealSourceResource($dealSource))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DealSource $dealSource)
    {
        abort_if(Gate::denies('deal_source_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealSourceResource($dealSource);
    }

    public function update(UpdateDealSourceRequest $request, DealSource $dealSource)
    {
        $dealSource->update($request->all());

        return (new DealSourceResource($dealSource))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DealSource $dealSource)
    {
        abort_if(Gate::denies('deal_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealSource->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
