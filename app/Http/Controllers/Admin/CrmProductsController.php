<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCrmProductRequest;
use App\Http\Requests\StoreCrmProductRequest;
use App\Http\Requests\UpdateCrmProductRequest;
use App\Models\CrmProduct;
use App\Models\ProductCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CrmProductsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('crm_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmProducts = CrmProduct::with(['product_category', 'media'])->get();

        return view('admin.crmProducts.index', compact('crmProducts'));
    }

    public function create()
    {
        abort_if(Gate::denies('crm_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product_categories = ProductCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.crmProducts.create', compact('product_categories'));
    }

    public function store(StoreCrmProductRequest $request)
    {
        $crmProduct = CrmProduct::create($request->all());

        if ($request->input('product_image', false)) {
            $crmProduct->addMedia(storage_path('tmp/uploads/' . basename($request->input('product_image'))))->toMediaCollection('product_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $crmProduct->id]);
        }

        return redirect()->route('admin.crm-products.index');
    }

    public function edit(CrmProduct $crmProduct)
    {
        abort_if(Gate::denies('crm_product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product_categories = ProductCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $crmProduct->load('product_category');

        return view('admin.crmProducts.edit', compact('crmProduct', 'product_categories'));
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

        return redirect()->route('admin.crm-products.index');
    }

    public function show(CrmProduct $crmProduct)
    {
        abort_if(Gate::denies('crm_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmProduct->load('product_category');

        return view('admin.crmProducts.show', compact('crmProduct'));
    }

    public function destroy(CrmProduct $crmProduct)
    {
        abort_if(Gate::denies('crm_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmProduct->delete();

        return back();
    }

    public function massDestroy(MassDestroyCrmProductRequest $request)
    {
        $crmProducts = CrmProduct::find(request('ids'));

        foreach ($crmProducts as $crmProduct) {
            $crmProduct->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('crm_product_create') && Gate::denies('crm_product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CrmProduct();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
