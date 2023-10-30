<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDealStageRequest;
use App\Http\Requests\StoreDealStageRequest;
use App\Http\Requests\UpdateDealStageRequest;
use App\Models\DealStage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DealStageController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('deal_stage_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealStages = DealStage::orderBy('order')->get();

        return view('admin.dealStages.index', compact('dealStages'));
    }

    public function create()
    {
        abort_if(Gate::denies('deal_stage_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealStages.create');
    }

    public function store(StoreDealStageRequest $request)
    {
        $dealStage = DealStage::create($request->all());

        return redirect()->route('admin.deal-stages.index');
    }

    public function edit(DealStage $dealStage)
    {
        abort_if(Gate::denies('deal_stage_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealStages.edit', compact('dealStage'));
    }

    public function update(UpdateDealStageRequest $request, DealStage $dealStage)
    {
        $dealStage->update($request->all());

        return redirect()->route('admin.deal-stages.index');
    }

    public function show(DealStage $dealStage)
    {
        abort_if(Gate::denies('deal_stage_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealStages.show', compact('dealStage'));
    }

    public function destroy(DealStage $dealStage)
    {
        abort_if(Gate::denies('deal_stage_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealStage->delete();

        return back();
    }

    public function massDestroy(MassDestroyDealStageRequest $request)
    {
        $dealStages = DealStage::find(request('ids'));

        foreach ($dealStages as $dealStage) {
            $dealStage->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
