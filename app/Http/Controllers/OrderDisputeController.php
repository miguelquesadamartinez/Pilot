<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Orders;
use App\Models\OrderDispute;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use Spatie\Permission\Models\Role;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderDisputeController extends Controller
{
    
    public function generateQRCode (string $orderNum){

        $order = OrderDispute::where('orderNum', '=', $orderNum)->get()[0];

        $url = url('/search-order-dispute/view/' . $orderNum);
        $qrCodeData = QrCode::format('png')->size(300)->generate($url);

        $pdf = new Dompdf();
        $pdf->loadHtml(view('pdf.qrCode', ['qrCodeData' => $qrCodeData, 'orderNum' => $orderNum, 'url' => $url, 'order' => $order]));
        $pdf->setPaper('A4');
        $pdf->render();

        return $pdf->stream($orderNum . ' - qrCode.pdf');
    }
    public function main(){
        SearchHelper::UsersActions();
        $order = null;
        $already_done = false;
        return view('disputes.search', compact('order', 'already_done'));
    }
    public function listOpen (){
        SearchHelper::UsersActions();
        $order_disputes = OrderDispute::select('orderNum', 'CIP', 'pharmacyName', 'open', 'validated')
                                        ->where('open', '=', '1')
                                        ->groupBy('orderNum', 'CIP', 'pharmacyName', 'open', 'validated')
                                        ->paginate(25);
        $status = 'open';
        return view('disputes.list', compact('order_disputes', 'status'));
    }
    public function listClosed (){
        SearchHelper::UsersActions();
        $order_disputes = OrderDispute::select('orderNum', 'CIP', 'pharmacyName', 'open', 'validated')
                                        ->where('open', '=', '0')
                                        ->groupBy('orderNum', 'CIP', 'pharmacyName', 'open', 'validated')
                                        ->paginate(25);
        $status = 'closed';
        return view('disputes.list', compact('order_disputes', 'status'));
    }
    public function searchList(Request $request){
        if ($request->status == 'open'){
            $order_disputes = OrderDispute::select('orderNum', 'CIP', 'pharmacyName', 'open')
            ->where('open', '=', '1')
            ->where('orderNum', '=', $request->OrderNumList)
            ->groupBy('orderNum', 'CIP', 'pharmacyName', 'open')
            ->paginate(25);
        } else {
            $order_disputes = OrderDispute::select('orderNum', 'CIP', 'pharmacyName', 'open')
            ->where('open', '=', '0')
            ->where('orderNum', '=', $request->OrderNumList)
            ->groupBy('orderNum', 'CIP', 'pharmacyName', 'open')
            ->paginate(25);
        }
        if (isset($order_disputes[0]->orderNum)){
            $orderNum = $order_disputes[0]->orderNum;
            $open = $order_disputes[0]->open;
        } else {
            $orderNum = null;
            $open = null;
        }
        $status = $request->status;
        session()->put('search_OrderNumList', $request->OrderNumList);
        return view('disputes.list', compact('order_disputes', 'orderNum', 'open', 'status'));
    }
    public function search(Request $request){
        $request->validate([
            'OrderNum' => 'required',
        ]);
        session()->put('search_OrderNum', $request->OrderNum);
        $already_done = false;
        $order = Orders::where('OrderNum', '=', $request->OrderNum)->get();
        if ( ! isset($order[0]->id) ) {
            $noResults = true;
            $order = null;
        } else {
            $noResults = false ;
            $order = Orders::find($order[0]->id);
            $check = OrderDispute::where('orderId', '=', $order->id)->get();
            if (count($check)) $already_done = true;
        }
        $orderNum = $request->OrderNum ;
        return view('disputes.search', compact('order', 'already_done', 'orderNum'));
    }
    public function saveDispute (Request $request, int $orderId){
        $check = OrderDispute::where('orderId', '=', $orderId)->get();
        if ( ! count($check)){
            $order = Orders::find($orderId);
            foreach ($order->orderItems as $item) {
                $order_dispute = new OrderDispute();
                $order_dispute->orderId = $order->id;
                $order_dispute->orderNum = $item->OrderNum;
                $order_dispute->orderItemId = $item->id;
                $order_dispute->orderItemProductId = $item->product_id;
                $order_dispute->orderItemProductName = $item->product_name;
                $order_dispute->orderItemQtn = intval($item->quantity);
                $order_dispute->orderItemPrice = $item->price;
                $order_dispute->orderItemTotal = $item->total;
                $order_dispute->orderItemDiscount = $item->discount;
                $order_dispute->ticked = 0;
                $order_dispute->open = 1;
                $order_dispute->CIP = $order->CIP;
                $order_dispute->pharmacyName = $order->pharmacyName;
                $order_dispute->country = $order->country;
                $order_dispute->save();
            }
            $order_dispute = OrderDispute::where('orderId', '=', $orderId)->get();
        } else {
            $order = Orders::find($orderId);
            $order_dispute = OrderDispute::where('orderId', '=', $orderId)->get();
        }
        $already_done = true;
        $orderNum = $order->OrderNum ;
        if ($order_dispute[0]->open) $status = 'open';
        else $status = 'closed';
        return view('disputes.view', compact('order_dispute', 'already_done', 'orderNum', 'status'));
    }
    public function view (Request $request, int $OrderNum){
        $success = null;
        if(session()->get('ticked_order_item') == true){
            $success = 'ticked_order_item';
            session()->forget('ticked_order_item');
        } else if (session()->get('status_order') == true){
            $success = 'status_order';
            session()->forget('status_order');
        } else if (session()->get('dispute_order_validated') == true){
            $success = 'dispute_order_validated';
            session()->forget('dispute_order_validated');
        } else {
            $success = null;
        }
        $order_dispute = OrderDispute::where('OrderNum', '=', $OrderNum)->get();
        $open = $order_dispute[0]->open;
        $already_done = true;
        $orderNum = $OrderNum;
        if ($open) $status = 'open';
        else $status = 'closed';
        return view('disputes.view', compact('order_dispute', 'already_done', 'orderNum', 'open', 'status', 'success'));
    }
    public function tick (Request $request, int $id){
        $order_dispute = OrderDispute::find($id);
        $order_dispute->ticked = ! $order_dispute->ticked;
        $order_dispute->save();
        session()->put('ticked_order_item', true);
        return redirect('/search-order-dispute/view/' . $order_dispute->orderNum);
    }
    public function status (Request $request, int $orderNum, string $status){
        $order_disputes = OrderDispute::where('OrderNum', '=', $orderNum)->get();
        foreach($order_disputes as $item){
            $order_dispute = OrderDispute::find($item->id);
            $order_dispute->open = ! $order_dispute->open;
            $order_dispute->save();
        }
        session()->put('status_order', true);
        return redirect('/search-order-dispute/view/' . $orderNum);
    }
    public function validateDispute (int $OrderNum){

        //ToDo: Here goes sage insert

        $order_disputes = OrderDispute::where('OrderNum', '=', $OrderNum)->get();
        foreach($order_disputes as $item){
            $order_dispute = OrderDispute::find($item->id);
            $order_dispute->validated = 1 ;
            $order_dispute->save();
        }
        session()->put('dispute_order_validated', true);
        return redirect('/search-order-dispute/view/' . $OrderNum);
    }
}
