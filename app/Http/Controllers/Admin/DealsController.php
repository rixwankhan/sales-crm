<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDealRequest;
use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Models\CrmContact;
use App\Models\CrmProduct;
use App\Models\Deal;
use App\Models\DealSource;
use App\Models\DealStage;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class DealsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('deal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deals = Deal::with(['contact_name', 'source', 'stage', 'products', 'created_by', 'media'])->get();

        return view('admin.deals.index', compact('deals'));
    }

    public function create()
    {
        abort_if(Gate::denies('deal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contact_names = CrmContact::pluck('contact_first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sources = DealSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stages = DealStage::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = CrmProduct::pluck('product_name', 'id');

        return view('admin.deals.create', compact('contact_names', 'products', 'sources', 'stages'));
    }

    public function store(StoreDealRequest $request)
    {
        $deal = Deal::create($request->all());
        $deal->products()->sync($request->input('products', []));
        foreach ($request->input('attachments', []) as $file) {
            $deal->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $deal->id]);
        }

        return redirect()->route('admin.deals.index');
    }

    public function edit(Deal $deal)
    {
        abort_if(Gate::denies('deal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contact_names = CrmContact::pluck('contact_first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sources = DealSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stages = DealStage::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = CrmProduct::pluck('product_name', 'id');

        $deal->load('contact_name', 'source', 'stage', 'products', 'created_by');

        return view('admin.deals.edit', compact('contact_names', 'deal', 'products', 'sources', 'stages'));
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

        return redirect()->route('admin.deals.index');
    }

    public function show(Deal $deal)
    {
        abort_if(Gate::denies('deal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deal->load('contact_name', 'source', 'stage', 'products', 'created_by');

        return view('admin.deals.show', compact('deal'));
    }

    public function destroy(Deal $deal)
    {
        abort_if(Gate::denies('deal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deal->delete();

        return back();
    }

    public function massDestroy(MassDestroyDealRequest $request)
    {
        $deals = Deal::find(request('ids'));

        foreach ($deals as $deal) {
            $deal->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('deal_create') && Gate::denies('deal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Deal();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
