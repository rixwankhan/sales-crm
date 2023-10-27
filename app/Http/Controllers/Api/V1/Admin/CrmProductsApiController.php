<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCrmProductRequest;
use App\Http\Requests\UpdateCrmProductRequest;
use App\Http\Resources\Admin\CrmProductResource;
use App\Models\CrmProduct;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrmProductsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('crm_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmProductResource(CrmProduct::with(['product_category'])->get());
    }

    public function store(StoreCrmProductRequest $request)
    {
        $crmProduct = CrmProduct::create($request->all());

        if ($request->input('product_image', false)) {
            $crmProduct->addMedia(storage_path('tmp/uploads/' . basename($request->input('product_image'))))->toMediaCollection('product_image');
        }

        return (new CrmProductResource($crmProduct))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CrmProduct $crmProduct)
    {
        abort_if(Gate::denies('crm_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmProductResource($crmProduct->load(['product_category']));
    }

    public function update(UpdateCrmProductRequest $request, CrmProduct $crmProduct)
    {
        $crmProduct->update($request->all());

        if ($request->input('product_image', false)) {
            if (! $crmProduct->product_image || $request->input('product_image') !== $crmProduct->product_image->file_name) {
                if ($crmProduct->product_image) {
                    $crmProduct->product_image->delete();
                }
                $crmProduct->addMedia(storage_path('tmp/uploads/' . basename($request->input('product_image'))))->toMediaCollection('product_image');
            }
        } elseif ($crmProduct->product_image) {
            $crmProduct->product_image->delete();
        }

        return (new CrmProductResource($crmProduct))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CrmProduct $crmProduct)
    {
        abort_if(Gate::denies('crm_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmProduct->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
