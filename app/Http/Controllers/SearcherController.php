<?php

namespace App\Http\Controllers;

use App\Mail\InfoMail;
use App\Models\Orders;
use App\Models\Tickets;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use App\Models\Ecommerce\Pharmacy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SearcherController extends Controller
{
    public function main(){
        SearchHelper::UsersActions();
        $pharmacy = null;
        $tickets = null;
        return view('admin.searcher.search', compact('pharmacy', 'tickets'));
    }
    public function search(Request $request){
        SearchHelper::UsersActions();
        $request->validate([
            'searchText' => 'required|min:5',
        ]);
        $searchText = trim($request->searchText);
        $user = Auth::user();
        if ($user->hasRole('TeleOperator')) {
            $orders = Orders::where('OrderNum', '=', $searchText)
                            ->orWhere('CIP', '=', $searchText)
                            ->get();
        } else {
            $orders = Orders::where('OrderNum', 'like', '%' . $searchText . '%')
                        //DeV: Add this for country orders view
                        //->where('country', '=', session()->get('locale'))
                        ->orWhere('CIP', 'like', '%' . $searchText . '%')
                        //->orWhere('colisNum', 'like', '%' . $searchText . '%')
                        ->orWhere('pharmacyName', 'like', '%' . $searchText . '%')
                        //->orWhere('zipCode', 'like', '%' . $searchText . '%')
                        //->orWhere('telephone', 'like', '%' . $searchText . '%')
                        //->orWhere('email', 'like', '%' . $searchText . '%')
                        //->orWhere('address', 'like', '%' . $searchText . '%')
                        //->orWhere('city', 'like', '%' . $searchText . '%')
                        ->orderBy('orderDate', 'desc')
                        ->get();
        }                   
        session()->put('search_string', $searchText);
        if (Count($orders) == 0){
            session()->put('order_id', '');
            session()->put('cip', '');
            $pharmacy = null;
            $tickets = null;
            $noResults = 1;

            $text = 'No results for order search: ' . $searchText ; 
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));

            return view('admin.searcher.search', compact('noResults', 'pharmacy', 'tickets'));
        // Here is the point, if only one result means that has founded the order, no ?
        } else if (Count($orders) == 1){
            $order = $orders[0];
            $items = $order->orderItems;
            session()->put('order_id', $order->id);
            session()->put('cip', $order->CIP);
            $invoices = SearchHelper::getInvoiceDB($order);
            $invoiceType = SearchHelper::getInvoiceType($order);
            $pharmacy = Pharmacy::where('cip', '=', $order->CIP)->get();
            //dd($order->CIP);
            if (isset($pharmacy[0]->id))
                $pharmacy = Pharmacy::find($pharmacy[0]->id);
            else{
                Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Missing pharmacy with CIP: ' . $order->CIP . ' at order: ' . $order->OrderNum ));
                $pharmacy = null;
            }
            return view('admin.orders.order', compact('order', 'items', 'invoices', 'invoiceType', 'pharmacy'));
        } else {
            $pharmacy = Pharmacy::where('cip', '=', $searchText)->get();
            if(count($pharmacy)){
                $pharmacy = Pharmacy::find($pharmacy[0]->id);
                $tickets = null;
                session()->put('order_id', '');
                session()->put('cip', $searchText);
            } else {
                $pharmacy = null;
                $tickets = null;
                session()->put('order_id', '');
                session()->put('cip', '');
            }
            return view('admin.searcher.search', compact('searchText', 'orders', 'pharmacy', 'tickets'));
        }   
    }
    public function viewProduct(Request $request, int $id){
        $product = OrderItems::find($id);
        return view('admin.searcher.viewproduct', compact('product'));
    }
}
