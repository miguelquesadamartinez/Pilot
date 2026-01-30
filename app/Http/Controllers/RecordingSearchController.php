<?php

namespace App\Http\Controllers;

use App\Models\RecordingSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\SearchHelper;
use App\Models\Ecommerce\TeleOperator;
use App\Models\Recordings;
use Illuminate\Support\Facades\DB;

class RecordingSearchController extends Controller
{
    public function main(Request $request){

        SearchHelper::UsersActions();

        return view('recordingsearch.main');
    }

    public function search(Request $request){

        SearchHelper::UsersActions();

        DB::enableQueryLog();

        $search_opr = $request->search_opr;
        $search_cip = $request->search_cip;
        $search_to = $request->search_to;
        $search_date = $request->search_date;
        $search_hour_from = $request->search_hour_from;
        $search_hour_to = $request->search_hour_to;

        if ( ! isset($request->page) && empty($search_opr) && empty($search_cip) && empty($search_to) && empty($search_date) && empty($search_hour_from) && empty($search_hour_to) ){
            return view('recordingsearch.main');
        }

        if (!empty($search_date)){
            //$date = date(app('global_format_date'), strtotime($search_date));
            $date = $search_date;
        } else {
            $date = '';
        }

        $recordings = RecordingSearch::orderBy('date', 'DESC')->orderBy('time', 'ASC');

        if (!empty($search_opr)){
            $recordings->where('operation','=', $search_opr);
        }
        if (!empty($search_cip)){
            $recordings->where('cip','=', $search_cip);
        }
        if (!empty($search_to)){
            $recordings->where('operator','=', $search_to);
        }
        if (!empty($date)){
            $recordings->where('date','=', $date);
        }

        if (!empty($search_hour_from) && empty($search_hour_to)){
            $recordings->where('time','>=', $search_hour_from);
        } else if (!empty($search_hour_from) && !empty($search_hour_to)) {
            $recordings->whereBetween('time', [$search_hour_from, $search_hour_to]);
        } else if (empty($search_hour_from) && !empty($search_hour_to)){
            $recordings->where('time','<=', $search_hour_to);
        }

        $recordings = $recordings->paginate(25);

        foreach($recordings as $temp){
            $temp->second_path = str_replace('/RECORDS', '', $temp->path);
            $temp->second_path = str_replace('/', '\\', $temp->second_path);
        }

        //SearchHelper::DebuggerTxT("Executed SQLs:");
        //SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();
        DB::disableQueryLog();

        return view('recordingsearch.main', compact('recordings', 'search_opr', 'search_cip', 'search_to', 'search_date', 'search_hour_from', 'search_hour_to'));
    }
}
