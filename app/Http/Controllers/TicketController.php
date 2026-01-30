<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Tickets;
use App\Models\OrderItems;
use App\Models\TicketFile;
use App\Models\TicketStatus;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use App\Helpers\TicketHelper;
use App\Models\tickets_level_a;
use App\Models\tickets_level_b;
use App\Models\tickets_level_c;
use App\Models\tickets_level_d;
use App\Models\tickets_level_e;
use App\Models\TicketCategories;
use App\Models\Ecommerce\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Ecommerce\OrderDetail;

class TicketController extends Controller
{
    
    public function main(){

        SearchHelper::UsersActions();

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));

        if (session()->get('msg') == 'ticket created'){
            $success = 'ticket created';
            session()->put('msg', '');
        } else if (session()->get('msg') == 'ticket edited'){
            $success = 'ticket edited';
            session()->put('msg', '');
        } else {
            $success = null;
        }

        session()->put('order_id','');
        session()->put('cip','');

        $currentDate = now();
        //$limitDate = $currentDate->subMonth();
        $limitDate = $currentDate->subMonths(env('MONTHS_FOR_TICKET_DASHBOARD', 3));

        $tickets = Tickets::where('country' ,'=', session()->get('locale'))
                            ->where('ticket_creation_date', '>', $limitDate)
                            ->orderBy('id', 'desc')
                            ->paginate(25);
        $status_var = "";
        return view('ticketing.main', compact('tickets', 'success', 'status_var'));
    }

    public function searchTicket (Request $request) {

        SearchHelper::UsersActions();

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));

        $query = Tickets::query();
            
        if($request->search != ""){
            $search = $request->search;
            $query = $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                            ->orWhere('description', 'like', '%' . $search . '%')
                            ->orWhere('order_number', 'like', '%' . $search . '%');
            });
        }

        if($request->ticket_type != "" && $request->ticket_type != "0"){
            $query = $query->where('ticket_type', $request->ticket_type);
        }

        if($request->category != ""){
            if ($request->category == "9999"){
                $query = $query->whereIn('categories_id', [1001, 1002, 1003, 1004, 1005, 1006, 1007, 1008, 1009, 1010, 1011, 1012]);
            } else {
                $query = $query->where('categories_id', $request->category);
            }
            
        }
        if($request->status != "" && $request->status != "0"){
            $query = $query->where('status_id', $request->status);
        }

        if($request->status == "0"){
            $query = $query->where('closed', '1');
        }

        $query = $query->limit(env('QUERY_LIMIT_RESULT'));

        $query = $query->orderBy('id', 'desc');

        $query = $query->where('country', session()->get('locale'));

        DB::enableQueryLog();

        $tickets = $query->get();

        //SearchHelper::DebuggerTxT("Executed SQLs:");
        //SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();

        DB::disableQueryLog();

        $search = $request->search;
        $category = $request->category;
        $status_var = $request->status;
        $ticket_type = $request->ticket_type;

        if($category){
            $status_category = TicketStatus::where('category_id', '=', $category)->get();
        } else {
            $status_category = TicketStatus::get();
        }

        return view('ticketing.main', compact('tickets', 'search', 'category', 'status_var', 'status_category', 'ticket_type'));
    }

    public function newTicket(){

        $searched_order_id = session()->get('order_id');
        $order = Orders::find($searched_order_id);

        if ( ! isset($order->id) )
            return redirect('/admin/searcher/main');

        $laboratory = trim(OrderItems::where('orders_id', '=', $order->id)->get()[0]->product_laboratory);

        return view('ticketing.newticket', compact('order', 'laboratory'));
    }

    public function createTicket(Request $request) {

        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'order_id' => 'required',
            'order' => 'required',
            'cip' => 'required',
        ]);

        $ticket = new Tickets();
        $ticket->title = $request->title;
        $ticket->description = $request->description;

        $ticket->ticket_type = $request->ticket_type;
        $ticket->categories_id = $request->category;

        if ($request->status)
            $ticket->status_id = $request->status;
        else
            $ticket->status_id = 1000;

        $ticket->level_a_id = $request->level_a;
        $ticket->level_b_id = $request->level_b;
        $ticket->level_c_id = $request->level_c;
        $ticket->level_d_id = $request->level_d;
        $ticket->level_e_id = $request->level_e;

        $ticket->orders_id = $request->order_id;

        $ticket->order_number = $request->order;
        $ticket->CIP = $request->cip;

        $temp_var = session()->get('locale');
        if($temp_var != "")
            $ticket->country = session()->get('locale');
        else
            $ticket->country = Auth::user()->language;

        $ticket->ticket_creation_date = date('Y-m-d');
        $ticket->ticket_creation_time = date('H:i:s');
        $ticket->ticket_update_date = date('Y-m-d');
        $ticket->ticket_update_time = date('H:i:s');

        $laboratory = trim(OrderItems::where('orders_id', '=', $request->order_id)->get()[0]->product_laboratory);

        if($laboratory == 'Biogyne' || $laboratory == 'BIOGYNE'){
            $ticket->department = TicketHelper::doActionsBiogyne($request->ticket_type, $request->category, $request->status, $ticket, true, $request->level_a, $request->level_b, $request->level_c, $request->level_d, $request->level_e);
            //$ticket->department = TicketHelper::doActions_2($request->category, $request->status, $ticket, true, $request->level_a, $request->level_b, $request->level_c, $request->level_d);
        } else {
            $ticket->department = TicketHelper::doActionsRest($request->category, $request->status, $ticket, true);
        }

        $ticket->save();

        if ($request->hasFile('ticket_file')) {
            $file = $request->file('ticket_file');
            $files = TicketFile::where('name', '=', $file->getClientOriginalName())
                                ->where('tickets_id', '=', $ticket->id)
                                ->get();
            //ToDo: Check if file exists
            if ( ! isset($files) || ! count($files)) {
                $ticketFile = new TicketFile;
                $ticketFile->name = $file->getClientOriginalName();
                $ticketFile->extension = $file->getClientOriginalExtension();
                $ticketFile->tickets_id = $ticket->id;
                $ticketFile->save();
                $request->ticket_file->storeAs('ticket_uploads/' . $ticket->id .'/' . $ticketFile->id . "/", $file->getClientOriginalName(), 'public');
            }
        }
        session()->put('msg', 'ticket created');
        return redirect('/ticketing/edit-ticket/' . $ticket->id);
    }

    public function editTicket(Request $request, int $id){
        $ticket = Tickets::find($id);
        $success = null;
        if(session()->get('msg') != ''){
            $success = session()->get('msg');
            session()->forget('msg');
        }
        $order = Orders::find($ticket->orders_id);
        $categories_type = TicketCategories::where('type_id', '=', $ticket->ticket_type)->where('active', '=', true)->get();
        $status = TicketStatus::where('category_id', '=', $ticket->categories_id)->get();
        $db_level_a = tickets_level_a::where('status_id', '=', $ticket->status_id)->get();
        $db_level_b = tickets_level_b::where('level_a_id', '=', $ticket->level_a_id)->get();
        $db_level_c = tickets_level_c::where('level_b_id', '=', $ticket->level_b_id)->get();
        $db_level_d = tickets_level_d::where('level_c_id', '=', $ticket->level_c_id)->get();
        $db_level_e = tickets_level_e::where('level_d_id', '=', $ticket->level_d_id)->get();
        $laboratory = trim(OrderItems::where('orders_id', '=', $ticket->orders_id)->get()[0]->product_laboratory);
        if($laboratory == 'Biogyne'){
            if($ticket->status_id == "2") {
                if($ticket->level_a_id == "1" && $ticket->level_b_id == "1" && $ticket->level_c_id == "1") {
                    $canCloseTheTicket = true;
                } else {
                    $canCloseTheTicket = false;
                }
            } else {
                $canCloseTheTicket = true;
            }
        } else {
            $canCloseTheTicket = true;
        }
        return view('ticketing.newticket', compact('order', 'ticket', 'categories_type', 'success', 'status', 'db_level_a', 'db_level_b', 'db_level_c', 'db_level_d', 'db_level_e', 'canCloseTheTicket', 'laboratory'));
    }

    public function updateTicket(Request $request){
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'category' => 'required',
            'ticket_type' => 'required',
        ]);
        $ticket = Tickets::find($request->ticket_id);
        // Save status value for knowing if have been changes

        $old_category = $ticket->categories_id;
        $old_status = $ticket->status_id;
        $old_level_a_id = $ticket->level_a_id;
        $old_level_b_id = $ticket->level_b_id;
        $old_level_c_id = $ticket->level_c_id;
        $old_level_d_id = $ticket->level_d_id;
        $old_level_e_id = $ticket->level_e_id;

        $ticket->title = $request->title;
        $ticket->description = $request->description;

        if ( $request->status != "0" ){
            $ticket->old_category_id = $ticket->categories_id;

            $ticket->last_status_id = $ticket->status_id;

            $ticket->old_level_a_id = $ticket->level_a_id;
            $ticket->old_level_b_id = $ticket->level_b_id;
            $ticket->old_level_c_id = $ticket->level_c_id;
            $ticket->old_level_d_id = $ticket->level_d_id;
            $ticket->old_level_e_id = $ticket->level_e_id;
        }

        if (isset($request->status)) {
            $ticket->status_id = $request->status;
        } else
            $ticket->status_id = 1000;

        $ticket->ticket_type = $request->ticket_type;
        $ticket->categories_id = $request->category;

        $ticket->level_a_id = $request->level_a;
        $ticket->level_b_id = $request->level_b;
        $ticket->level_c_id = $request->level_c;
        $ticket->level_d_id = $request->level_d;
        $ticket->level_e_id = $request->level_e;

        if ( $request->status == "0" ){
            $ticket->closed = true;
            //$ticket->closingDate = Carbon::now();
            $ticket->closingDate = date(app('global_format_datetime'));
            //$ticket->closingDate = date('Y-d-m'); 
        } else {
            $ticket->closed = false;
            $ticket->closingDate = null;
        }

        if ($request->hasFile('ticket_file')) {
            $file = $request->file('ticket_file');
            $ticketFile = new TicketFile;
            $ticketFile->name = $file->getClientOriginalName();
            $ticketFile->tickets_id = $ticket->id;
            $ticketFile->extension = $file->getClientOriginalExtension();
            $ticketFile->save();
            $request->ticket_file->storeAs('ticket_uploads/' . $ticket->id .'/' . $ticketFile->id . "/", $file->getClientOriginalName(), 'public');
        }

        $producto = OrderItems::where('orders_id', '=', $request->order_id)->get()[0];

        $laboratory = trim($producto->product_laboratory);

        if($laboratory == 'Biogyne' || $laboratory == 'BIOGYNE'){
            if ($old_category != $request->category || $old_status != $request->status || $old_level_a_id != $request->level_a || $old_level_b_id != $request->level_b || $old_level_c_id != $request->level_c || $old_level_d_id != $request->level_d || $old_level_e_id != $request->level_e ){
                $ticket->department = TicketHelper::doActionsBiogyne($request->ticket_type, $request->category, $request->status, $ticket, true, $request->level_a, $request->level_b, $request->level_c, $request->level_d, $request->level_e);
            }
        } else {
            if ($old_category != $request->category || $old_status != $request->status ){
                $ticket->department = TicketHelper::doActionsRest($request->category, $request->status, $ticket, true);
            }
        }
        
        $ticket->ticket_update_date = date('Y-m-d');
        $ticket->ticket_update_time = date('H:i:s');

        $ticket->save();

        session()->put('msg', 'ticket edited');

        return redirect('/ticketing/edit-ticket/' . $ticket->id);
    }

    public function deleteFile (Request $request, int $id) {

        $fileDB = TicketFile::find($id);

        $directory = App::basePath() . "\\storage\\app\\public\\ticket_uploads\\" . $fileDB->tickets_id . "\\" . $fileDB->id . "\\";

        $filePath = $directory . $fileDB->name;

        unlink($filePath);
        //rmdir($directory);
        
        TicketFile::find($id)->delete();

        $ticket = Tickets::find($fileDB->tickets_id);

        session()->put('msg', 'ticket file deleted');

        return redirect('/ticketing/edit-ticket/' . $ticket->id);
    }

    public function manage(){
        return view('ticketing.manage');
    }
    public function newCategory(){
        return view('ticketing.newcategory');
    }

    public function createCategory(Request $request){

        $request->validate([
            'category_en' => 'required|unique:ticket_categories',
            'category_es' => 'required',
            'category_fr' => 'required',
        ]);

        $ticket = new TicketCategories();
        $ticket->category_en = $request->category_en;
        $ticket->category_es = $request->category_es;
        $ticket->category_fr = $request->category_fr;
        $ticket->save();

        $categories = TicketCategories::all();

        return view('ticketing.manage', compact('categories'))->with('success', 'new cat');

    }

    public function editCategory(Request $request, int $id){

        $category = TicketCategories::find($id);

        return view('ticketing.editcategory', compact('category'));
    }

    public function updateCategory(Request $request){

        $request->validate([
            'category_en' => 'required',
            'category_es' => 'required',
            'category_fr' => 'required',
        ]);

        $cat = TicketCategories::find($request->category_id);
        $cat->category_en = $request->category_en;
        $cat->category_es = $request->category_es;
        $cat->category_fr = $request->category_fr;
        $cat->save();

        $categories = TicketCategories::all();

        return view('ticketing.manage', compact('categories'))->with('success', 'cat edited');
    }


    public function newStatus(){
        return view('ticketing.newstatus');
    }

    public function createStatus(Request $request){
        $request->validate([
            'status_en' => 'required|unique:ticket_statuses',
            'status_es' => 'required',
            'status_fr' => 'required',
            'category' => 'required',
        ]);
        $status = new TicketStatus();
        $status->status_en = $request->status_en;
        $status->status_es = $request->status_es;
        $status->status_fr = $request->status_fr;
        $status->category_id = $request->category;
        $status->save();
        $status = TicketStatus::all();
        return view('ticketing.manage', compact('status'))->with('success', 'new stat');
    }
    public function editStatus(Request $request, int $id){
        $status = TicketStatus::find($id);
        return view('ticketing.editstatus', compact('status'));
    }
    public function updateStatus(Request $request){
        $request->validate([
            'status_en' => 'required',
            'status_es' => 'required',
            'status_fr' => 'required',
            'category' => 'required',
        ]);
        $cat = TicketStatus::find($request->status_id);
        $cat->status_en = $request->status_en;
        $cat->status_es = $request->status_es;
        $cat->status_fr = $request->status_fr;
        $cat->category_id = $request->category;
        $cat->save();
        $status = TicketStatus::all();
        return view('ticketing.manage', compact('status'))->with('success', 'status edited');
    }
    public function dashboardAdmin(){

        $currentDate = now();
        //$limitDate = $currentDate->subMonth();
        $limitDate = $currentDate->subMonths(env('MONTHS_FOR_TICKET_DASHBOARD', 3));

        $tickets = Tickets::where('country', session()->get('locale'))
                            ->where('ticket_creation_date', '>', $limitDate)
                            //->limit(env('QUERY_LIMIT_RESULT'))
                            ->orderBy('id', 'desc')
                            //->paginate(25)
                            ->get();
        $tickets = TicketHelper::addDateDiffToObjectWithoutWeekends($tickets);
        
        $status_var = "";
        $dept_var = "";
        $days_sla = env('TICKETING_DAYS_FOR_ALERT');
        return view('ticketing.dashboardAdmin', compact('tickets', 'status_var', 'dept_var', 'days_sla'));
    }

    public function searchAdminTicket (Request $request) {
        //DB::enableQueryLog();
        $query = Tickets::query();
        if($request->department != ""){
            $query = $query->where('department', $request->department);
        }
        if($request->ticket_type != "" && $request->ticket_type != "0"){
            $query = $query->where('ticket_type', $request->ticket_type);
        }
        if ($request->category == "9999"){
            $query = $query->whereIn('categories_id', [1001, 1002, 1003, 1004, 1005, 1006, 1007, 1008, 1009, 1010, 1011, 1012]);
        } else {
            if ($request->category != "")
                $query = $query->where('categories_id', $request->category);
        }
        if($request->status != ""){
            $query = $query->where('status_id', $request->status);
        }
        //$query->limit(env('QUERY_LIMIT_RESULT'));
        $query->orderBy('id', 'desc');
        
        $query->where('country', session()->get('locale'));

        $currentDate = now();
        $limitDate = $currentDate->subMonths(env('MONTHS_FOR_TICKET_DASHBOARD', 3));
        $query->where('ticket_creation_date', '>', $limitDate);

        $tickets = $query->get();

        //SearchHelper::DebuggerTxT("Executed SQLs:");
        //SearchHelper::bindBuilderQuery(DB::getQueryLog());
        //DB::flushQueryLog();
        //DB::disableQueryLog();

        $tickets = TicketHelper::addDateDiffToObjectWithoutWeekends($tickets);
        $search = $request->search;
        $ticket_type = $request->ticket_type;
        $category = $request->category;
        $status_var = $request->status;
        $dept_var = $request->department;
        if($category){
            $status_category = TicketStatus::where('category_id', '=', $category)->get();
        } else {
            $status_category = TicketStatus::get();
        }
        $days_sla = env('TICKETING_DAYS_FOR_ALERT');
        return view('ticketing.dashboardAdmin', compact('tickets', 'search', 'category', 'status_var', 'status_category', 'dept_var', 'days_sla', 'ticket_type'));
    }
/*
    public function searchAdminTicket_old (Request $request) {
        $query = Tickets::query(); 
        if($request->search != ""){
            $search = $request->search;
            $query = $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('order_number', 'like', '%' . $search . '%');
            });
        }
        if($request->category != ""){
            $query = $query->where('categories_id', $request->category);
        }
        if($request->status != "" && $request->status != "0"){
            $query = $query->where('status_id', $request->status);
        }
        if($request->status == "0"){
            $query = $query->where('closed', '1');
            if ($request->department == '1'){ // After Sales
                $query = $query->whereIn('last_status_id', [1]);
                //$query = $query->whereIn('last_status_id', [1, 2, 3]);
            } else if ($request->department == '2') { // Logistics
                    $query = $query->where(function($query) {
                        $query->whereIn('categories_id', [3])
                            ->OrWhereIn('last_status_id', [4, 5, 6, 7, 8, 9, 10]);
                    });
            } else if ($request->department == '3') { // Production
                $query = $query->where(function($query){
                    $query->whereIn('categories_id', [3])
                        ->orWhereIn('last_status_id', [2, 3]);
                });
            } else if ($request->department == '4') { // Accounting
                //$query = $query->whereIn('categories_id', [1, 2, 3]);
                //$query = $query->whereIn('status_id', [1, 2, 3]);
            } else if ($request->department == '5') { // Lawyers
                //$query = $query->whereIn('categories_id', [1, 2, 3]);
                //$query = $query->whereIn('status_id', [1, 2, 3]);
            } else if ($request->department == '6') { // It
                //$query = $query->whereIn('categories_id', [1, 2, 3]);
                //$query = $query->whereIn('status_id', [1, 2, 3]);
            }
        } else { 

            if($request->status == ""){
                //$query = $query->where(function($query) {
                //    $query = $query->where('closed', '1');
                //});
            }

            if ($request->department == '1'){ // After Sales
                $query = $query->whereIn('status_id', [1]);

                if($request->status == ""){
                    if($request->category == ""){
                        $query = $query->orWhere(function($query) {
                            $query->where('closed', 1)
                                ->where('last_status_id', 1);
                        });
                    } else {
                        $status = $request->category;
                        $query = $query->orWhere(function($query) use ($status) {
                            $query->where('closed', 1)
                                ->where('last_status_id', 1)
                                ->where('categories_id', $status);
                        });
                    }
                }

                //$query = $query->whereIn('status_id', [1, 2, 3]);
            } else if ($request->department == '2') { // Logistics

                if($request->status == ""){

                    $query = $query->where(function($query) {
                        $query = $query->orWhere(function($query) {
                            $query->whereIn('categories_id', [3])
                                ->OrWhereIn('status_id', [4, 5, 6, 7, 8, 9, 10]);
                        });   
                        $query = $query->orWhere(function($query) {
                            $query->whereIn('categories_id', [3])
                                ->OrWhereIn('last_status_id', [4, 5, 6, 7, 8, 9, 10]);
                            $query = $query->where(function($query) {
                                $query->where('closed', 1);
                            });
                        });   
                    });

                } else {
                    $query = $query->where(function($query) {
                        $query->whereIn('categories_id', [3])
                            ->OrWhereIn('status_id', [4, 5, 6, 7, 8, 9, 10]);
                    });
                }

            } else if ($request->department == '3') { // Production

                if($request->status == ""){

                    $query = $query->where(function($query) {
                        $query = $query->orWhere(function($query) {
                            $query->whereIn('categories_id', [3])
                                ->OrWhereIn('status_id', [2, 3]);
                        });   
                        $query = $query->orWhere(function($query) {
                            $query->whereIn('categories_id', [3])
                                ->OrWhereIn('last_status_id', [2, 3]);
                            $query = $query->where(function($query) {
                                $query->where('closed', 1);
                            });
                        });   
                    });

                } else {
                    $query = $query->where(function($query) {
                        $query->whereIn('categories_id', [3])
                            ->OrWhereIn('status_id', [2, 3]);
                    });
                }

            } else if ($request->department == '4') { // Accounting
                $query = $query->whereIn('categories_id', [6]);
                //$query = $query->whereIn('status_id', [1, 2, 3]);
            } else if ($request->department == '5') { // Lawyers
                $query = $query->whereIn('categories_id', [7]);
                //$query = $query->whereIn('status_id', [1, 2, 3]);
            } else if ($request->department == '6') { // It
                $query = $query->whereIn('categories_id', [8]);
                //$query = $query->whereIn('status_id', [1, 2, 3]);
            }
        }

        $query->limit(env('QUERY_LIMIT_RESULT'));

        $query->orderBy('created_at', 'desc');

        $query->where('country', session()->get('locale'));

        DB::enableQueryLog();

        $tickets = $query->get();

        //$tickets = TicketHelper::addDateDiffToObject($tickets);
        $tickets = TicketHelper::addDateDiffToObjectWithoutWeekends($tickets);

        //$tickets = TicketHelper::addDepartmentToTicket($tickets);

        //SearchHelper::DebuggerTxT("Executed SQLs:");
        //SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();

        DB::disableQueryLog();

        $search = $request->search;
        $category = $request->category;
        $status_var = $request->status;
        $dept_var = $request->department;

        if($category){
            $status_category = TicketStatus::where('category_id', '=', $category)->get();
        } else {
            $status_category = TicketStatus::get();
        }

        $days_sla = env('TICKETING_DAYS_FOR_ALERT');

        return view('ticketing.dashboardAdmin', compact('tickets', 'search', 'category', 'status_var', 'status_category', 'dept_var', 'days_sla'));
    }
*/
    public function departmentDashboard(Request $request, string $department){
        $currentDate = now();
        $limitDate = $currentDate->subMonths(env('MONTHS_FOR_TICKET_DASHBOARD', 3));
        $query = Tickets::query();
        $query = $query->where('ticket_creation_date', '>', $limitDate);
        $query = $query->where('department', '=', $department);
        $query = $query->where('closed', '=', '0');
        $query = $query->where('country', '=', session()->get('locale'));
        $query = $query->orderBy('id', 'asc');
        $tickets = $query->get();
        $status_var = "";
        $page = $department ;
        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));
    }

/*
    public function dashboardAfterSales(){

        //$from = Carbon::today()->subMonth()->toDateString() . " 00:00:00";
        $from = Carbon::today()->subDays(env('DAYS_FOR_TICKET_DASHBOARD'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date'), strtotime($from . " 00:00:00"));

        $tickets = Tickets::where('created_at', '>=', $from)
                            ->where('country' ,'=', session()->get('locale'))

                            //->whereIn('categories_id', [3])
                            ->whereIn('status_id', [1])

                            ->where('closed', false)
                            ->get();

        $status_var = "";
        $page = "AfterSales" ;

        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));
    }

    public function dashboardLogistics (){

        $from = Carbon::today()->subDays(env('DAYS_FOR_TICKET_DASHBOARD'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date'), strtotime($from . " 00:00:00"));

        $query = Tickets::query();
         
        $query = $query->where('created_at', '>=', $from);
        $query = $query->where('closed', '=', '0');
        $query = $query->where('country', '=', session()->get('locale'));

        $search = $from;
        $query = $query->where(function($query) use ($search) {
            $query->whereIn('categories_id', [3])
                  ->orWhereIn('status_id', [4, 5, 6, 7, 8, 9, 10]);
        });

        $tickets = $query->get();

        $status_var = "";
        $page = "Logistics" ;

        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));

    }

    public function dashboardProduction(){

        $from = Carbon::today()->subDays(env('DAYS_FOR_TICKET_DASHBOARD'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date'), strtotime($from . " 00:00:00"));

        $query = Tickets::query();
         
        $query = $query->where('updated_at', '>=', $from);
        $query = $query->where('closed', '=', '0');
        $query = $query->where('country', '=', session()->get('locale'));

        $search = $from;
        $query = $query->where(function($query) use ($search) {
            $query->whereIn('categories_id', [3])
                  ->orWhereIn('status_id', [2, 3]);
        });

        $tickets = $query->get();

        $status_var = "";
        $page = "Production" ;

        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));
    }

    public function dashboardLegal(){

        $from = Carbon::today()->subDays(env('DAYS_FOR_TICKET_DASHBOARD'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date'), strtotime($from . " 00:00:00"));

        $query = Tickets::query();
         
        $query = $query->where('updated_at', '>=', $from);
        $query = $query->where('department', '=', 'Legal');
        $query = $query->where('closed', '=', '0');
        $query = $query->where('country', '=', session()->get('locale'));


        $tickets = $query->get();

        $status_var = "";
        $page = "Legal" ;

        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));
    }

    public function dashboardIT(){

        $from = Carbon::today()->subDays(env('DAYS_FOR_TICKET_DASHBOARD'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date'), strtotime($from . " 00:00:00"));

        $query = Tickets::query();
         
        $query = $query->where('updated_at', '>=', $from);
        $query = $query->where('department', '=', 'TI');
        $query = $query->where('closed', '=', '0');
        $query = $query->where('country', '=', session()->get('locale'));

        $tickets = $query->get();

        $status_var = "";
        $page = "TI" ;

        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));
    }

    public function dashboardAfterSalesNew(){

        $from = Carbon::today()->subDays(env('DAYS_FOR_TICKET_DASHBOARD'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date'), strtotime($from . " 00:00:00"));

        $query = Tickets::query();
         
        $query = $query->where('updated_at', '>=', $from);
        $query = $query->where('department', '=', 'AfterSales');
        $query = $query->where('closed', '=', '0');
        $query = $query->where('country', '=', session()->get('locale'));

        $tickets = $query->get();

        $status_var = "";
        $page = "AfterSales" ;

        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));
    }
    
    public function dashboardLogisticsNew(){

        DB::enableQueryLog();

        $from = Carbon::today()->subDays(env('DAYS_FOR_TICKET_DASHBOARD'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date'), strtotime($from . " 00:00:00"));

        $query = Tickets::query();
         
        $query = $query->where('updated_at', '>=', $from);
        $query = $query->where('department', '=', 'Logistics');
        $query = $query->where('closed', '=', '0');
        $query = $query->where('country', '=', session()->get('locale'));

        $tickets = $query->get();

        $status_var = "";
        $page = "Logistics" ;

        //SearchHelper::DebuggerTxT("Executed SQLs:");
        //SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();
        DB::disableQueryLog();

        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));
    }
    
    public function dashboardProductionNew(){

        $from = Carbon::today()->subDays(env('DAYS_FOR_TICKET_DASHBOARD'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date'), strtotime($from . " 00:00:00"));

        $query = Tickets::query();
         
        $query = $query->where('updated_at', '>=', $from);
        $query = $query->where('department', '=', 'Production');
        $query = $query->where('closed', '=', '0');
        $query = $query->where('country', '=', session()->get('locale'));

        $tickets = $query->get();

        $status_var = "";
        $page = "Production" ;

        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));
    }
    
    public function dashboardLitigation(){

        $from = Carbon::today()->subDays(env('DAYS_FOR_TICKET_DASHBOARD'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date'), strtotime($from . " 00:00:00"));

        $query = Tickets::query();
         
        $query = $query->where('updated_at', '>=', $from);
        $query = $query->where('department', '=', 'Litigation');
        $query = $query->where('closed', '=', '0');
        $query = $query->where('country', '=', session()->get('locale'));

        $tickets = $query->get();

        $status_var = "";
        $page = "Production" ;

        return view('ticketing.dashboardGeneral', compact('tickets', 'status_var', 'page'));
    }
*/

    
}
