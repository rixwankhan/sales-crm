<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Http\Resources\Admin\DealResource;
use App\Models\Deal;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DealsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('deal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealResource(Deal::with(['contact_name', 'source', 'stage', 'products', 'created_by'])->get());
    }

    public function store(StoreDealRequest $request)
    {
        $deal = Deal::create($request->all());
        $deal->products()->sync($request->input('products', []));
        foreach ($request->input('attachments', []) as $file) {
            $deal->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        return (new DealResource($deal))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Deal $deal)
    {
        abort_if(Gate::denies('deal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealResource($deal->load(['contact_name', 'source', 'stage', 'products', 'created_by']));
    }

    public function update(UpdateDealRequest $request, Deal $deal)
    {
        $deal->update($request->all());
        $deal->products()->sync($request->input('products', []));
        if (count($deal->attachments) > 0) {
            foreach ($deal->attachments as $media) {
                if (! in_array($media->file_name, $request->input('attachments', []))) {
                    $media->delete();
                }
            }
        }
        $media = $deal->attachments->pluck('file_name')->toArray();
        foreach ($request->input('attachments', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $deal->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
            }
        }

        return (new DealResource($deal))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Deal $deal)
    {
        abort_if(Gate::denies('deal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deal->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
