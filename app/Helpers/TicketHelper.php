<?php

namespace App\Helpers;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Mail\OpenTicket;
use App\Mail\ClosedTicket;
use App\Models\TicketStatus;
use App\Mail\ValidationOrNot;
use App\Mail\ReadingSaleRecord;
use App\Mail\UrgentTask;
use App\Models\TicketCategories;
use Illuminate\Support\Facades\Mail;

class TicketHelper {
    public static function doActionsRest ($category_id, $status_id, $ticket, $new) {

        $dept = $ticket->department;

        if (session()->get('locale') == 'en'){
            if ($new){
                $text = 'has been created';
            } else {
                $text = 'changed to';
            }
        } else if (session()->get('locale') == 'es'){
            if ($new){
                $text = 'ha sido creado';
            } else {
                $text = 'cambiado a';
            }
        } else if (session()->get('locale') == 'fr'){
            if ($new){
                $text = 'a été créé';
            } else {
                $text = 'changé en';
            }
        }

        if ($category_id == '1001'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_COMMERCIAL_PROBLEM_ADARE') )->send(new OpenTicket($ticket, $text));
                $dept = "ADARE" ;
            } else {
                Mail::to( env('EMAIL_FOR_COMMERCIAL_PROBLEM_ADARE') )->send(new ClosedTicket($ticket, $text));
                $dept = "ADARE" ;
            }
        } else if ($category_id == '1002'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_ADARE') )->send(new OpenTicket($ticket, $text));
                $dept = "ADARE" ;
            } else {
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_ADARE') )->send(new ClosedTicket($ticket, $text));
                $dept = "ADARE" ;
            }
        } else if ($category_id == '1003'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_THERAMEX') )->send(new OpenTicket($ticket, $text));
                $dept = "THERAMEX" ;
            } else {
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_THERAMEX') )->send(new ClosedTicket($ticket, $text));
                $dept = "THERAMEX" ;
            }
        } else if ($category_id == '1004'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_THERAMEX') )->send(new OpenTicket($ticket, $text));
                $dept = "THERAMEX" ;
            } else {
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_THERAMEX') )->send(new ClosedTicket($ticket, $text));
                $dept = "THERAMEX" ;
            }
        } else if ($category_id == '1005'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_AGINAX') )->send(new OpenTicket($ticket, $text));
                $dept = "AGINAX" ;
            } else {
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_AGINAX') )->send(new ClosedTicket($ticket, $text));
                $dept = "AGINAX" ;
            }
        } else if ($category_id == '1006'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_AGINAX') )->send(new OpenTicket($ticket, $text));
                $dept = "AGINAX" ;
            } else {
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_AGINAX') )->send(new ClosedTicket($ticket, $text));
                $dept = "AGINAX" ;
            }
        } else if ($category_id == '1007'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_BNSANTE_GC') )->send(new OpenTicket($ticket, $text));
                $dept = "BNSANTE_GC" ;
            } else {
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_BNSANTE_GC') )->send(new ClosedTicket($ticket, $text));
                $dept = "BNSANTE_GC" ;
            }
        } else if ($category_id == '1008'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_BNSANTE_GC') )->send(new OpenTicket($ticket, $text));
                $dept = "BNSANTE_GC" ;
            } else {
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_BNSANTE_GC') )->send(new ClosedTicket($ticket, $text));
                $dept = "BNSANTE_GC" ;
            }
        } else if ($category_id == '1009'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_LIFESTYLES') )->send(new OpenTicket($ticket, $text));
                $dept = "LIFESTYLES" ;
            } else {
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_LIFESTYLES') )->send(new ClosedTicket($ticket, $text));
                $dept = "LIFESTYLES" ;
            }
        } else if ($category_id == '1010'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_LIFESTYLES') )->send(new OpenTicket($ticket, $text));
                $dept = "LIFESTYLES" ;
            } else {
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_LIFESTYLES') )->send(new ClosedTicket($ticket, $text));
                $dept = "LIFESTYLES" ;
            }
        } else if ($category_id == '1011'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_HAVEA_FR') )->send(new OpenTicket($ticket, $text));
                $dept = "HAVEA_FR" ;
            } else {
                Mail::to( env('EMAIL_FOR_SALES_PROBLEM_HAVEA_FR') )->send(new ClosedTicket($ticket, $text));
                $dept = "HAVEA_FR" ;
            }
        } else if ($category_id == '1012'){
            if ($status_id != '0'){
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_HAVEA_FR') )->send(new OpenTicket($ticket, $text));
                $dept = "HAVEA_FR" ;
            } else {
                Mail::to( env('EMAIL_FOR_LOGISTICS_PROBLEM_HAVEA_FR') )->send(new ClosedTicket($ticket, $text));
                $dept = "HAVEA_FR" ;
            }
        }

        return $dept;
    }

    public static function doActionsBiogyne ($ticket_type, $category_id, $status_id, $ticket, $new, $level_a, $level_b, $level_c, $level_d, $level_e) {

        $ticket->urgent_task = false;
        $ticket->department_urgent_task = null;
        $ticket->supervisor_task = false;
        $ticket->supervisor_id = null;
        $ticket->reminder = false;
        $ticket->department_reminder = null;
        $ticket->reminder_date = null;
        $ticket->reminder_time = null;

        $dept = $ticket->department;
        if (session()->get('locale') == 'en'){
            if ($new){ $text = 'has been created'; } else { $text = 'changed to'; }
        } else if (session()->get('locale') == 'es'){
            if ($new){ $text = 'ha sido creado'; } else { $text = 'cambiado a'; }
        } else if (session()->get('locale') == 'fr'){
            if ($new){ $text = 'a été créé'; } else { $text = 'changé en'; }
        }

        if ($status_id == 0){
            Mail::to( env('EMAIL_FOR_CLOSED_TICKET'))->send(new ClosedTicket($ticket, $text));
        } else {

            // Order

            if ($category_id == "1"){ // Order / False order
                if ($status_id == "1"){ // Order made by customer
                    if ($level_a == "1") { // Customer accepts order
                        if ($level_b == "1") { // LCR Paid - Customer accepts order
                            $ticket = TicketHelper::closeTicket($ticket, $text);
                        } else if ($level_b == "2") { // Unpaid LCR - Customer accepts order
                            if ($level_c == "1") { // Pending payment
                                if ($level_d == "1") { // Cloture - Pending payment - Unpaid LCR - Customer accepts order
                                    $ticket = TicketHelper::closeTicket($ticket, $text);
                                }
                            } else if ($level_c == "2") { // Client refuse 
                                Mail::to(env('EMAIL_FOR_LEGAL'))->send(new ReadingSaleRecord($ticket, $text));
                                $dept = "Legal" ;
                            }
                        }
                    } else if ($level_a == "2") { // Customer refuses order
                        if ($level_b == "3") { // LCR Paid - Customer refuses order
                            if ($level_c == "3") { // Good Buy Accept 
                                if ($level_d == "2") { // Validated voucher
                                    if ($level_e == "1") { // Cloture - Validated voucher - Good Buy Accept - LCR Paid - Customer refuses order
                                        $ticket = TicketHelper::closeTicket($ticket, $text);
                                    } else {
                                        Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                                        $dept = "Logistics" ;
                                    }
                                } else {
                                    Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                                    $dept = "Production" ;
                                }
                            } else if ($level_c == "4") { // Good purchase not accepted 
                                if ($level_d == "3") { // Credit Memo 
                                    if ($level_e == "2") { // Cloture - Credit Memo - Good purchase not accepted- LCR Paid - Customer refuses order
                                        $ticket = TicketHelper::closeTicket($ticket, $text);
                                    } else {
                                        Mail::to(env('EMAIL_FOR_ACCOUNTIG'))->send(new ReadingSaleRecord($ticket, $text));
                                        $dept = "Accounting" ;
                                    }
                                } else {
                                    Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                                    $dept = "Production" ;
                                }
                            }
                        }  else if ($level_b == "4") { // Unpaid LCR - Customer refuses order
                            if ($level_c == "5") { // Waiting for return goods 
                                if ($level_d == "4") { // Cloture - Waiting for return goods - Unpaid LCR - Customer refuses order
                                    $ticket = TicketHelper::closeTicket($ticket, $text);
                                } else {
                                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                                    $dept = "Logistics" ;
                                }
                            }
                        }
                    }
                }
            } else if ($category_id == "2"){ // Product ordered / Reference error

            } else if ($category_id == "3"){ // Order modification or cancellation

            }
            // Logistics
            else if ($category_id == "4"){ // Order not delivered 
                if ($status_id == ""){ // Non existent order
                    if ($level_a == "") { // Explain case

                    }
                } else if ($status_id == ""){ // Existent order – Urgent task – Sup Task

                    $ticket->urgent_task = true;
                    $ticket->department_urgent_task = 'logistics';

                    $ticket->supervisor_task = true;
                    // Logistics supervisor ?
                    $ticket->supervisor_id = 'how ?';

                }

            } else if ($category_id == "5"){ // Preparation error: missing 

            } else if ($category_id == "6"){ // Broken/damaged product 

            } else if ($category_id == "7"){ // Product returned different from shipped product 

            } 
            // Invoicing
            else if ($category_id == "8"){ // Delivery error 

            } else if ($category_id == "9"){ // Unrealized credit 

            } else if ($category_id == "10"){ // Credit note not refunded 

            } else if ($category_id == "11"){ // Credit note not applied 

            } else if ($category_id == "12"){ // Account Change / Change of Holder 

            } else if ($category_id == "13"){ // LCR collected 2 times

            } else if ($category_id == "14"){ // Purchase coupon not applied
                if ($status_id == "6"){ // Purchase coupon Catalog 

                } else if ($status_id == "7"){ // Purchase coupon Purchase 

                } else if ($status_id == "8"){ // Disputed logistics fees 

                }
            } 
            // Clubbiogyne
            else if ($category_id == "15"){ // Client not created

            } else if ($category_id == "16"){ // Customer does not know these Codes

            } else if ($category_id == "17"){ // Unvalidated code 

            } else if ($category_id == "18"){ // Change email address 

            } else if ($category_id == "19"){ // The page is not displayed 

            } else if ($category_id == "20"){ // The good d’Purchase does not displayed 

            } 
            // Expired product  
            else if ($category_id == "21"){ // Excluding promotion offer 

            } else if ($category_id == "22"){ // With short expiry promotion offer 

            } 
            // Other service  
            else if ($category_id == "23"){ // Order declined
           
            } else if ($category_id == "24"){ // Order refused request by the after-sales service

            } else if ($category_id == "25"){ // Returned order 

            } else if ($category_id == "26"){ // Partial order returned 

            } else if ($category_id == "27"){ // Product returned different from expected product 

            } else if ($category_id == "28"){ // Unpaid LCR (no return)

            }

            if ($category_id == "1"){ // 
                if ($status_id == "1"){ // 
                    if ($level_a == "1") { //  
                        if ($level_b == "1") { //  
                            if ($level_c == "1") { // 
                                if ($level_d == "1") { // 
                                    if ($level_e == "1") { // 

                                        Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                                        $dept = "Production" ;

                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $ticket =TicketHelper::doTicketProcedures($ticket);

        return $dept;
    }

    public static function doTicketProcedures ($ticket){
        $text = '';
        if ($ticket->supervisor_task){
            // need to get email from supervisor, maybe .env
            Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
        }
        if ($ticket->urgent_task){
            $text = __('Urgent task');
            if ($ticket->department_urgent_task == 'logistics'){
                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new UrgentTask($ticket, $text));
            }
        }
        if ($ticket->reminder){
            //$ticket->reminder_date
            //$ticket->reminder_time
        }

        return $ticket;
    }

    public static function closeTicket($ticket, $text){
        $ticket->closed = true;
        $ticket->closingDate = Carbon::now();
        Mail::to( env('EMAIL_FOR_CLOSED_TICKET'))->send(new ClosedTicket($ticket, $text));
        return $ticket;
    }

    public static function addDateDiffToObject($tickets){

        $var = Carbon::now()->format('Y-m-d h:i:s');

        foreach($tickets as $ticket){

            if($ticket->closed){
                $str_date = (string)(strtotime($ticket->closingDate) - strtotime($ticket->created_at)) / 86400;
            } else {
                $str_date = (string)(strtotime(Carbon::now()->format('Y-m-d h:i:s')) - strtotime($ticket->created_at)) / 86400;
            }
            
            $ticket->date_diff = substr($str_date, 0, strpos($str_date, '.', 0));

            //$ticket->date_temp = Carbon::now()->format('Y-m-d h:i:s');
        }

        return $tickets;
    }

    public static function addDateDiffToObjectWithoutWeekends($tickets){

        foreach($tickets as $ticket){

            $start = new DateTime($ticket->created_at);

            if($ticket->closed){
                $end = new DateTime($ticket->closingDate);    
            } else {
                $end = new DateTime(Carbon::now()->format('Y-m-d h:i:s'));
                //$end = new DateTime(Carbon::now()->format('Y-m-d'));
            }

            //ToDo: De lo contrario, se excluye la fecha de finalización ?
            //Esto parece que no sirve, pero lo dejo como referencia
            //$end->modify('+1 day');

            $interval = $end->diff($start);
    
            // total dias
            $days = $interval->days;

            // crea un período de fecha iterable (P1D equivale a 1 día)
            $period = new DatePeriod($start, new DateInterval('P1D'), $end);

            //ToDo: Añadir feriados
            if(session()->get('locale') == 'es'){
                $holidays = array(
                                    '2023-12-06', 
                                    '2013-12-08'
                                 );
            } else if (session()->get('locale') == 'fr'){
                $holidays = array(
                                    '2023-12-06', 
                                    '2013-12-08'
                                 );
            } else {
                $holidays = array();
            }

            foreach($period as $dt) {
                $curr = $dt->format('D');

                // obtiene si es Sábado o Domingo
                if($curr == 'Sat' || $curr == 'Sun') {
                    $days--;
                } elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                    $days--;
                }
            }
            
            $ticket->date_diff = $days;
            //$ticket->date_temp = Carbon::now()->format('Y-m-d h:i:s');
        }

        return $tickets;
    }


    public static function checkServer($ip){
        $ch = curl_init($ip);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        //dd($httpcode);

        //if($httpcode !== 0 && $httpcode != 302){
        if($httpcode !== 0){
          return true;
        } else {
          return false;
        }
        
    }

/*
    public static function addDepartmentToTicket($tickets){

        $array_aftersales = array(1);
        $array_logistics = array(4, 5, 6, 7, 8, 9, 10);
        $array_production = array(2, 3);

        foreach($tickets as $ticket){

            //ToDo: OJO !! $ticket->closed = 1

            if ( in_array($ticket->status_id, $array_aftersales) || ( in_array($ticket->last_status_id, $array_aftersales) && $ticket->closed = 1 ) ){
                $ticket->department = 'AfterSales' ;
            } else if ( in_array($ticket->status_id, $array_logistics) || ( in_array($ticket->last_status_id, $array_logistics) && $ticket->closed = 1 ) ){
                $ticket->department = 'Logistics' ;
            } else if ( in_array($ticket->status_id, $array_production) || ( in_array($ticket->last_status_id, $array_production) && $ticket->closed = 1 ) ){
                $ticket->department = 'Production' ;
            }
        
        }

        return $tickets;
    }

    // Old Biogyne actions
    public static function doActions_2 ($category_id, $status_id, $ticket, $new, $level_a, $level_b, $level_c, $level_d) {

        $dept = $ticket->department;

        if (session()->get('locale') == 'en'){
            if ($new){ $text = 'has been created'; } else { $text = 'changed to'; }
        } else if (session()->get('locale') == 'es'){
            if ($new){ $text = 'ha sido creado'; } else { $text = 'cambiado a'; }
        } else if (session()->get('locale') == 'fr'){
            if ($new){ $text = 'a été créé'; } else { $text = 'changé en'; }
        }

        if ($status_id == 0){
            Mail::to( env('EMAIL_FOR_CLOSED_TICKET'))
                ->send(new ClosedTicket($ticket, $text));
        } else {
            if ($category_id == "8"){ // Order not delivered
                if ($level_a == "5") { // No order
                    Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Production" ;
                } else if ($status_id == "11"){ // Sage non-integrated order
                    Mail::to(env('EMAIL_FOR_TI'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "TI" ;
                } else {
                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Logistics" ;
                }
            } else if ($category_id == "9"){ // Missing Item
                if ($status_id == "12"){ // Unordered item
                    Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Production" ;
                } else {
                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Logistics" ;
                }
            } else if ($category_id == "10"){ // Parcel sent several times
                if ($level_a == "9") { // Return slip
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else if ($status_id == "18"){ // Duplicate orders
                    Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Production" ;
                } else if ($status_id == "19"){ // Logistical error
                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Logistics" ;
                } else {
                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Logistics" ;
                }
            } else if ($category_id == "11"){ // Order modification/cancellation
                Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Production" ;
            } else if ($category_id == "12"){ // Good buy
                if ($level_a == "13") { // Credit Memo - Incorrect/unavailable
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else if ($status_id == "25"){ // incorrect/unavailable
                    Mail::to(env('EMAIL_FOR_LITIGATION'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Litigation" ;
                } else if ($status_id == "26"){ // Updated customer - Good buy
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else {
                    Mail::to(env('EMAIL_FOR_TI'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "TI" ;
                }
            } else if ($category_id == "13"){ // Credit note not received
                Mail::to(env('EMAIL_FOR_LITIGATION'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Litigation" ;
            } else if ($category_id == "14"){ // Incorrect invoice information
                if ($level_a == "10") { // New information
                    Mail::to(env('EMAIL_FOR_LITIGATION'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Litigation" ;
                } else if ($status_id == "20"){ // Request for information - Incorrect invoice information
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else {
                    Mail::to(env('EMAIL_FOR_LITIGATION'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Litigation" ;
                }
            } else if ($category_id == "15"){ // Direct debit 2 times
                if ($status_id == "27"){ // Credit Memo - Direct debit 2 times
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else {
                    Mail::to(env('EMAIL_FOR_LITIGATION'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Litigation" ;
                }
            } else if ($category_id == "16"){ // Non-existent customer
                if ($status_id == "21"){ // Request for information - Non-existent customer
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else if ($status_id == "22"){ // Updated customer - Non-existent customer
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else {
                    Mail::to(env('EMAIL_FOR_TI'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "TI" ;
                }
            } else if ($category_id == "17"){ // Connection problem
                if ($level_a == "12") { // New information
                    Mail::to(env('EMAIL_FOR_LITIGATION'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Litigation" ;
                } else if ($status_id == "23"){ // Request for information - Connection problem
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else if ($status_id == "24"){ // Problem to be corrected
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else {
                    Mail::to(env('EMAIL_FOR_TI'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "TI" ;
                }
            } else if ($category_id == "18"){ // Uncollected credit
                if ($status_id == "13"){ // Payment already made
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else if ($status_id == "14"){ // Payment not made
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                }
            } else if ($category_id == "5"){ // Delivery Error
                if ($level_a == "15" || $level_a == "16" || $level_a == "17") { // Return slip
                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;
                } else if ($status_id == "15"){ // Other address
                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Logistics" ;
                } else if ($status_id == "16"){ // Other pharmacy
                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Logistics" ;
                } else if ($status_id == "17"){ // Reverse control
                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Logistics" ;
                } else {
                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Logistics" ;
                }
            } else {
                if ($status_id == "2"){ // Validation or not of the order

                    if ($level_a == "1") { // Actual Order

                        if ($level_b == "1"){ // Customer Accepts Actual order

                            if ($level_c == "1"){ // Yes Accepts Actual order

                                // Can close the ticket
                                $dept = "AfterSales" ;

                            } else if ($level_c == "2"){ // No Accepts Actual order

                                if ($level_d == "1"){ // Customer refusal No Accepts Actual order

                                    Mail::to(env('EMAIL_FOR_LEGAL'))->send(new ReadingSaleRecord($ticket, $text));
                                    $dept = "Legal" ;
                                    
                                } else if ($level_d == "2"){ // Customer accepts No Accepts Actual order
                                    
                                    //Mail::to(env('EMAIL_FOR_AFTERSALES'))
                                    //->later(now()->addDays(1), new ReadingSaleRecord($ticket, $text));
                                    //->later(Carbon::now()->addMinutes(10), new ReadingSaleRecord($ticket, $text));

                                    //Mail::to(env('EMAIL_FOR_AFTERSALES'))
                                    //->queue((new ReadingSaleRecord($ticket, $text))->delay(86400));

                                    // Run remainder
                                    $dept = "AfterSales" ;

                                }
                            }

                        } else if ($level_b == "2"){ // Customer refusal Actual order

                            if ($level_c == "3"){ // Yes refusal Actual order

                                if ($level_d == "3"){ // Customer accepts Yes Accepts Actual order

                                    Mail::to(env('EMAIL_FOR_TI'))->send(new ReadingSaleRecord($ticket, $text));
                                    $dept = "TI" ;
        
                                } else if ($level_d == "4"){ // Customer refusal Yes Accepts Actual order
                                    
                                    Mail::to(env('EMAIL_FOR_LEGAL'))->send(new ReadingSaleRecord($ticket, $text));
                                    $dept = "Legal" ;

                                }

                            } else if ($level_c == "4"){ // No refusal Actual order

                                if ($level_d == "5"){ // Yes - No refusal Actual order

                                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                                    $dept = "Logistics" ;
        
                                } else if ($level_d == "6"){ // No - No refusal Actual order
                                    
                                    Mail::to(env('EMAIL_FOR_LEGAL'))->send(new ReadingSaleRecord($ticket, $text));
                                    $dept = "Legal" ;

                                }
                            }
                        }
                    }

                } else if ($status_id == "5"){ // Product is missing

                    if ($level_a == "2") { // Missing product (Invoiced)

                        if ($level_b == "3"){ // Customer insists – 1st time

                            Mail::to(env('EMAIL_FOR_LITIGATION'))->send(new ReadingSaleRecord($ticket, $text));
                            $dept = "Litigation" ;

                        } else if ($level_b == "4"){ // Customer insists – 2nd time

                            Mail::to(env('EMAIL_FOR_LITIGATION'))->send(new ReadingSaleRecord($ticket, $text));
                            $dept = "Litigation" ;

                        } else if ($level_b == "5"){ // Customer refusal - Invoiced

                            Mail::to(env('EMAIL_FOR_LEGAL'))->send(new ReadingSaleRecord($ticket, $text));
                            $dept = "Legal" ;

                        } else if ($level_b == "6"){ // Voucher validated

                            Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                            $dept = "Logistics" ;

                        }

                    } else if ($level_a == "3") { // Missing product (Not invoiced)

                        if ($level_b == "7"){ // Order to cancel - Not invoiced

                            Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                            $dept = "Production" ;

                        } else if ($level_b == "8"){ // Seized product

                            if ($level_c == "5") { // Propose new order - Seized

                                Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                                $dept = "Production" ;

                            } else if ($level_c == "6") { // Returns missing product

                                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                                $dept = "Logistics" ;

                            }

                        } else if ($level_b == "9"){ // Product not entered

                            if ($level_c == "7") { // Propose new order - Not entered
                                Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                                $dept = "Production" ;
                            }

                        }
                    }

                } else if ($status_id == "6"){ // Order not received

                    if ($level_a == "4") { // Disruptive product

                        if ($level_b == "10"){ // Order to cancel - Disruptive

                            Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                            $dept = "Production" ;

                        } else if ($level_b == "11"){ // Urgent shipment

                            Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                            $dept = "Logistics" ;

                        }
                    }
                  
                } else if (in_array($status_id, [1])){ // AfterSales

                    Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "AfterSales" ;

                } else if (in_array($status_id, [4, 5, 6, 7, 8, 9, 10])){ // Logistics

                    Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Logistics" ;

                } else if (in_array($status_id, [3])){ // Production

                    Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                    $dept = "Production" ;

                } else {

                    $text = "Not matched category";
                    Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new ReadingSaleRecord($ticket, $text));
                    
                }
            }
        }
        return $dept;
    }
  
    public static function doActions_3 ($category_id, $status_id, $ticket, $new) {

        $dept = $ticket->department;

        if (session()->get('locale') == 'en'){
            if ($new){
                $text = 'has been created';
            } else {
                $text = 'changed to';
            }
        } else if (session()->get('locale') == 'es'){
            if ($new){
                $text = 'ha sido creado';
            } else {
                $text = 'cambiado a';
            }
        } else if (session()->get('locale') == 'fr'){
            if ($new){
                $text = 'a été créé';
            } else {
                $text = 'changé en';
            }
        }

        if ($status_id == 0){
            Mail::to( env('EMAIL_FOR_CLOSED_TICKET'))
                ->send(new ClosedTicket($ticket, $text));
        } else {

            if ($status_id == "2"){ // Reading the Sale Record

                Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "AfterSales" ;

            } else if ($status_id == "2"){ // Validation or not of the order

                Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Production" ;
 
            } else if ($status_id == "3"){ // Real Fake Order

                Mail::to(env('EMAIL_FOR_PRODUCTION'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Production" ;

            } else if ($status_id == "4"){ // Product Lack

                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Logistics" ;

            } else if ($status_id == "5"){ // Product is missing

                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Logistics" ;

            } else if ($status_id == "6"){ // Order not received

                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Logistics" ;

            } else if ($status_id == "7"){ // Logistics Entry Entered Returns by GLS Number

                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Logistics" ;

            } else if ($status_id == "8"){ // Order returns not received by BN

                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Logistics" ;

            } else if ($status_id == "9"){ // Delivered to another pharmacy

                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Logistics" ;

            } else if ($status_id == "10"){ // GLS delivers with good label and wrong address

                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));
                $dept = "Logistics" ;

            } else {

                $text = "Not matched category for non Biogyne order";
                Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new ReadingSaleRecord($ticket, $text));
                
            }
        }

        return $dept;

    }

    public static function doActions ($category_id, $status_id, $ticket, $new) {

        $category = TicketCategories::find($category_id);
        $status = TicketStatus::find($status_id);

        if (session()->get('locale') == 'en'){
            if ($new){
                $text = 'has been created';
            } else {
                $text = 'changed to';
            }
        } else if (session()->get('locale') == 'es'){
            if ($new){
                $text = 'ha sido creado';
            } else {
                $text = 'cambiado a';
            }
        } else if (session()->get('locale') == 'fr'){
            if ($new){
                $text = 'a été créé';
            } else {
                $text = 'changé en';
            }
        }

        if ($status_id == 0){
            Mail::to( env('EMAIL_FOR_CLOSED_TICKET'))
                ->cc( env('EMAIL_FOR_BCC'))
                ->send(new ClosedTicket($ticket, $text));
        } else {
    
            switch ($category->category_en) {
                case 'False order':

                    switch ($status->status_en) {
                        case 'Reading the Sale Record':
            
                            Mail::to( env('EMAIL_FOR_READING_SALE_RECORD'))
                            ->cc( env('EMAIL_FOR_BCC'))
                            ->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                        case 'Validation or not of the order':
            
                            Mail::to(env('EMAIL_FOR_VALIDATION_OR_NOT'))->cc(env('EMAIL_FOR_BCC'))->send(new ValidationOrNot($ticket, $text));
            
                        break;
                        case 'Real Fake Order':
            
                            Mail::to(env('EMAIL_FOR_FAKE_ORDER'))->cc(env('EMAIL_FOR_BCC'))->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                    }
                        
                break;
                case 'Wrong Quantity':
                    switch ($status->status_en) {
                        case 'Product Lack':
            
                            Mail::to(env('EMAIL_FOR_PRODUCT_LACK'))->cc(env('EMAIL_FOR_BCC'))->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                        case 'Product is missing':
            
                            Mail::to(env('EMAIL_FOR_PRODUCT_MISSING'))->cc(env('EMAIL_FOR_BCC'))->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                        case 'Order not received':
            
                            Mail::to(env('EMAIL_FOR_ORDER_NOT_RECIVED'))->cc(env('EMAIL_FOR_BCC'))->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                    }
                break;

                case 'Duplicated order receipt':
    

                break;
                
                case 'Late order received refused':
                    switch ($status->status_en) {
                        case 'Logistics Entry Entered Returns by GLS Number':
            
                            Mail::to(env('EMAIL_FOR_LATE_ORDER_REFUSED'))->cc(env('EMAIL_FOR_BCC'))->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                        case 'Order returns not received by BN':
            
                            Mail::to(env('EMAIL_FOR_ORDER_RETURNS'))->cc(env('EMAIL_FOR_BCC'))->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                        case 'GLS delivers with good label and wrong address':
            
                            Mail::to(env('EMAIL_FOR_WRONG_ADDRESS'))->cc(env('EMAIL_FOR_BCC'))->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                    }
                break;

                case 'Delivery Error':
                    switch ($status->status_en) {
                        case 'Delivered to another pharmacy':
            
                            Mail::to(env('EMAIL_FOR_DELIVERED_TO_ANOTHER'))->cc(env('EMAIL_FOR_BCC'))->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                        case 'GLS delivers with good label and wrong address':
            
                            Mail::to(env('EMAIL_FOR_WRONG_ADDRESS'))->cc(env('EMAIL_FOR_BCC'))->send(new ReadingSaleRecord($ticket, $text));
            
                        break;
                    }
                break;
        
            }
        }
    }
*/
}