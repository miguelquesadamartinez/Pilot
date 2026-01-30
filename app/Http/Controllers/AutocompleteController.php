<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{

    public function autocompleteOrderNum (Request $request)
    {
        if($request->has('search')){
            $search = $request->search;
            $data = DB::table("orders")
            ->select("id", "OrderNum")
            ->where('OrderNum','LIKE',"%$search%")
            ->limit(25)
            ->get();
        }

        return response()->json($data);
    }

    public function autocompleteCip(Request $request) 
    {
        if($request->has('search')){
            $search = $request->search;
            $data = DB::table("orders")
            ->select("id", "CIP")
            ->where('CIP','LIKE',"%$search%")
            ->limit(25)
            ->get();
        }

        return response()->json($data);
    }

    public function autocompleteSearch(Request $request) 
    {

        $searchType = SearchHelper::getSearchType($request->search);

        if($request->has('search')){
            $search = $request->search;
            $data = DB::table("orders")
            ->select("id", "OrderNum")
            ->where('CIP','LIKE',"%$search%")
            ->orWhere('CIP', 'like', '%' . $search . '%')
            ->orWhere('tracking_number', 'like', '%' . $search . '%')
            ->orWhere('pharmacyName', 'like', '%' . $search . '%')
            ->limit(10)
            ->get();
        }

        return response()->json($data);
    }
}
