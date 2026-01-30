<?php

namespace App\Http\Controllers;

use App\Models\OutOfStock;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;

class OutOfStockController extends Controller
{
    public function productsOutOfStock (Request $request){
        SearchHelper::UsersActions();
        $out_of_stock = OutOfStock::all();
        $success = null;
        if(session()->get('msg') != ''){
            $success = session()->get('msg');
            session()->forget('msg');
        }
        return view('out.main', compact('out_of_stock', 'success'));
    }
    public function newProductsOutOfStock (Request $request){
        return view('out.editoutofstock');
    }
    public function createProductsOutOfStock (Request $request){
        $request->validate([
            'product_id' => 'required',
            'peremption_date' => 'required',
        ]);
        $out_of_stock = new OutOfStock();
        $id = OutOfStock::max('id') + 1;
        $out_of_stock->id = $id;
        $out_of_stock->product_id = $request->product_id;
        $out_of_stock->peremption_date = $request->peremption_date;
        $out_of_stock->save();
        session()->put('msg', 'out created');
        return redirect('/edit-products-out-of-stock/' . $id);
    }
    public function editProductsOutOfStock (Request $request, int $id){
        $out_of_stock = OutOfStock::find($id);
        $success = null;
        if(session()->get('msg') != ''){
            $success = session()->get('msg');
            session()->forget('msg');
        }
        return view('out.editoutofstock', compact('out_of_stock', 'success'));
    }
    public function updateProductsOutOfStock (Request $request){
        $request->validate([
            'product_id' => 'required',
            'peremption_date' => 'required',
        ]);
        $out_of_stock = OutOfStock::find($request->stock_id);
        $out_of_stock->product_id = $request->product_id;
        $out_of_stock->peremption_date = $request->peremption_date;
        $out_of_stock->save();
        session()->put('msg', 'out edited');
        return redirect('/edit-products-out-of-stock/' . $request->stock_id);
    }
    public function deleteProductsOutOfStock(Request $request, int $id){
        OutOfStock::find($id)->delete();
        $out_of_stock = OutOfStock::all();
        $message = 'out deleted';
        session()->put('msg', 'out deleted');
        return redirect('/products-out-of-stock');
    }
}
