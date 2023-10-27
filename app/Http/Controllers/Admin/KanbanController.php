<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\DealStage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class KanbanController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('deal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deal_stage = DealStage::select('id','name','order')->orderBy('order')->get();
        // $deals = Deal::where('deleted_at', null)->orderByDesc('created_at')->get();
        $deals = DB::table('deals')
        ->select('deals.*','deal_sources.name')
        ->join('deal_sources', 'deals.source_id', '=', 'deal_sources.id')
        ->where('deals.deleted_at', '=', null)
        ->orderBy('deals.created_at', 'desc')
        ->get();

        
        return view('admin.kanban.index', ['deal_stage' => $deal_stage, 'deals' => $deals]);
    }
    

}