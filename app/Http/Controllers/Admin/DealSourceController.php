<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDealSourceRequest;
use App\Http\Requests\StoreDealSourceRequest;
use App\Http\Requests\UpdateDealSourceRequest;
use App\Models\DealSource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DealSourceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deal_source_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealSources = DealSource::all();

        return view('admin.dealSources.index', compact('dealSources'));
    }

    public function create()
    {
        abort_if(Gate::denies('deal_source_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealSources.create');
    }

    public function store(StoreDealSourceRequest $request)
    {
        $dealSource = DealSource::create($request->all());

        return redirect()->route('admin.deal-sources.index');
    }

    public function edit(DealSource $dealSource)
    {
        abort_if(Gate::denies('deal_source_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealSources.edit', compact('dealSource'));
    }

    public function update(UpdateDealSourceRequest $request, DealSource $dealSource)
    {
        $dealSource->update($request->all());

        return redirect()->route('admin.deal-sources.index');
    }

    public function show(DealSource $dealSource)
    {
        abort_if(Gate::denies('deal_source_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealSources.show', compact('dealSource'));
    }

    public function destroy(DealSource $dealSource)
    {
        abort_if(Gate::denies('deal_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealSource->delete();

        return back();
    }

    public function massDestroy(MassDestroyDealSourceRequest $request)
    {
        $dealSources = DealSource::find(request('ids'));

        foreach ($dealSources as $dealSource) {
            $dealSource->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
