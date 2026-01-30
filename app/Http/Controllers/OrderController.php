<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use App\Models\Ecommerce\Pharmacy;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function viewOrder(Request $request, int $id){

        $success = false;

        if(session()->get('updated_recording') == true){
            $success = 'updated_recording';
            session()->forget('updated_recording');
        } else {
            $success = false;
        }

        $order = Orders::find($id);
        if(isset($order->id)){
            session()->put('order_id', $order->id);
            session()->put('cip', $order->CIP);

            $invoices = SearchHelper::getInvoiceDB($order);
            $invoiceType = SearchHelper::getInvoiceType($order);

            $pharmacy = Pharmacy::where('cip', '=', $order->CIP)->get();
            $pharmacy = Pharmacy::find($pharmacy[0]->id);

            return view('admin.orders.order', compact('order', 'invoices', 'invoiceType', 'pharmacy', 'success'));
        } else {
            return redirect()->back();
        }
    }
}

