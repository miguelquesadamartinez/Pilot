<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ecommerce\Product;
use Illuminate\Support\Facades\DB;

class GetController extends Controller
{

    public function productList(Request $request, ?string $search = null){
        $product = new Product();
        $filters = $request->all();
        $products = $product->search($search, $filters);
        return response()->json(['products' =>  $products], (!empty($products)) ? 200 : 404);
    }
    public function getOrderNum(Request $request) 
    {
        if($request->has('order_id')){
            $search = $request->order_id;
            $data = DB::table("orders")
            ->select("id", "OrderNum")
            ->where('id','=',$search)
            ->get();
        }
        return response()->json($data);
    }

    public function getCipFromOrderNum(Request $request) 
    {
        if($request->has('order_id')){
            $search = $request->order_id;
            $data = DB::table("orders")
            ->select("CIP")
            ->where('id','=',$search)
            ->get();
        }

        return response()->json($data);
    }

    public function getCategoryFromType(Request $request){
     
        $data = null;

        if($request->has('type_id')){
            $search = $request->type_id;
            
            if($request->type_id != ""){
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("ticket_categories")
                    ->select("id", "category_fr as category")
                    ->where('type_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("ticket_categories")
                    ->select("id", "category_es as category")
                    ->where('type_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("ticket_categories")
                    ->select("id", "category_en as category")
                    ->where('type_id','=',$search)
                    ->get();
                }
            } else {
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("ticket_categories")
                    ->select("id", "category_fr as category")
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("ticket_categories")
                    ->select("id", "category_es as category")
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("ticket_categories")
                    ->select("id", "category_en as category")
                    ->get();
                }   
            }
        }
        
        return response()->json($data);
    }

    public function getStatusFromCategory(Request $request){

        $data = null;

        if($request->has('category_id')){
            $search = $request->category_id;
            
            if($request->category_id != ""){
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("ticket_statuses")
                    ->select("id", "status_fr as status")
                    ->where('category_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("ticket_statuses")
                    ->select("id", "status_es as status")
                    ->where('category_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("ticket_statuses")
                    ->select("id", "status_en as status")
                    ->where('category_id','=',$search)
                    ->get();
                }
            } else {
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("ticket_statuses")
                    ->select("id", "status_fr as status")
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("ticket_statuses")
                    ->select("id", "status_es as status")
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("ticket_statuses")
                    ->select("id", "status_en as status")
                    ->get();
                }   
            }
        }

        return response()->json($data);
    }

    public function getLevel1forStatus(Request $request){

        $data = null;

        if($request->has('status_id')){
            $search = $request->status_id;
            
            if($request->status_id != ""){
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_as")
                    ->select("id", "level_a_fr as level_a")
                    ->where('status_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_as")
                    ->select("id", "level_a_es as level_a")
                    ->where('status_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_as")
                    ->select("id", "level_a_en as level_a")
                    ->where('status_id','=',$search)
                    ->get();
                }
            } else {
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_as")
                    ->select("id", "level_a_fr as level_a")
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_as")
                    ->select("id", "level_a_es as level_a")
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_as")
                    ->select("id", "level_a_en as level_a")
                    ->get();
                }   
            }
        }

        return response()->json($data);
    }

    public function getLevel2forLevel1(Request $request){

        $data = null;

        if($request->has('level_a_id')){
            $search = $request->level_a_id;
            
            if($request->level_a_id != ""){
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_bs")
                    ->select("id", "level_b_fr as level_b")
                    ->where('level_a_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_bs")
                    ->select("id", "level_b_es as level_b")
                    ->where('level_a_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_bs")
                    ->select("id", "level_b_en as level_b")
                    ->where('level_a_id','=',$search)
                    ->get();
                }
            } else {
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_bs")
                    ->select("id", "level_b_fr as level_b")
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_bs")
                    ->select("id", "level_b_es as level_b")
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_bs")
                    ->select("id", "level_b_en as level_b")
                    ->get();
                }   
            }
        }

        return response()->json($data);
    }

    public function getLevel3forLevel2(Request $request){

        $data = null;

        if($request->has('level_b_id')){
            $search = $request->level_b_id;
            
            if($request->level_b_id != ""){
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_cs")
                    ->select("id", "level_c_fr as level_c")
                    ->where('level_b_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_cs")
                    ->select("id", "level_c_es as level_c")
                    ->where('level_b_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_cs")
                    ->select("id", "level_c_en as level_c")
                    ->where('level_b_id','=',$search)
                    ->get();
                }
            } else {
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_cs")
                    ->select("id", "level_c_fr as level_c")
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_cs")
                    ->select("id", "level_c_es as level_c")
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_cs")
                    ->select("id", "level_c_en as level_c")
                    ->get();
                }   
            }
        }

        return response()->json($data);
    }

    public function getLevel4forLevel3(Request $request){

        $data = null;

        if($request->has('level_c_id')){
            $search = $request->level_c_id;
            
            if($request->level_c_id != ""){
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_ds")
                    ->select("id", "level_d_fr as level_d")
                    ->where('level_c_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_ds")
                    ->select("id", "level_d_es as level_d")
                    ->where('level_c_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_ds")
                    ->select("id", "level_d_en as level_d")
                    ->where('level_c_id','=',$search)
                    ->get();
                }
            } else {
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_ds")
                    ->select("id", "level_d_fr as level_d")
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_ds")
                    ->select("id", "level_d_es as level_d")
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_ds")
                    ->select("id", "level_d_en as level_d")
                    ->get();
                }   
            }
        }

        return response()->json($data);
    }

    public function getLevel5forLevel4(Request $request){

        $data = null;

        if($request->has('level_d_id')){
            $search = $request->level_d_id;
            
            if($request->level_c_id != ""){
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_es")
                    ->select("id", "level_e_fr as level_e")
                    ->where('level_d_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_es")
                    ->select("id", "level_e_es as level_e")
                    ->where('level_d_id','=',$search)
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_es")
                    ->select("id", "level_e_en as level_e")
                    ->where('level_d_id','=',$search)
                    ->get();
                }
            } else {
                if( session()->get('locale') == 'fr' ) {
                    $data = DB::table("tickets_level_es")
                    ->select("id", "level_e_fr as level_e")
                    ->get();
                } else if (session()->get('locale') == 'es') {
                    $data = DB::table("tickets_level_es")
                    ->select("id", "level_e_es as level_e")
                    ->get();
                } else if (session()->get('locale') == 'en') {
                    $data = DB::table("tickets_level_es")
                    ->select("id", "level_e_en as level_e")
                    ->get();
                }   
            }
        }

        return response()->json($data);
    }
}
