<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Mail\InfoMail;
use App\Models\Orders;
use App\Models\Tickets;
use App\Mail\ReportMail;
use App\Models\Delivery;
use App\Models\OrderItems;
use App\Models\Recordings;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use App\Models\DeliveryFiles;
use App\Mail\ReadingSaleRecord;
use App\Models\Ecommerce\Order;
use App\Models\RecordingSearch;
use App\Mail\PharmaciesModified;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\Pharmacy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Models\Ecommerce\OrderDetail;
use Illuminate\Support\Facades\Storage;

class CronController extends Controller
{

    public function updateProductDiscounts (){

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
        SearchHelper::UsersActions();

        //$from = Carbon::today()->subDays(env('GET_ORDERS_FROM_DAYS'))->toDateString() . " 00:00:00";

        $from = date(app('global_format_date')) . " 00:00:00";
        $to = date(app('global_format_date')) . " 23:59:59";

        //$from = "20241014 00:00:00";
        //$to = "20241015 23:59:59";

        $orders_ecommerce = Order::select('id')
                                    ->whereBetween('updated_at', [$from, $to])
                                    ->where('status', 'confirmed')
                                    ->get();
        //dump($orders_ecommerce);
        if ( count($orders_ecommerce) ) {
            foreach($orders_ecommerce as $order_1){
                $products = OrderDetail::where('order_id', '=', $order_1->id)->get();
                //dump($products);
                foreach($products as $product){
                    //dump($product->product_id);
                    $result = DB::select("
                    EXEC	[ecommerce].[dbo].[CheckProductPromotionPriceV2]
                            @product_id = ?,
                            @order_id = ?",
                    [$product->product_id, $product->order_id]);
                    //dump($result[0]->product_discount . ' - ' . $result[0]->promo_id);
                }
                //dump('middle');
                //dump($order_1->id);
                $order = Order::find($order_1->id);
                //dump($order->getTotal());
                //dump($order->getTotalWithDiscount());
                Order::where('id', $order->id)
                ->update(['amount' => $order->getTotalWithDiscount()]);
                $order->updated_at = date(app('global_format_date').' H:i:s');
                $order->save();
            }
        }
    }

    public function getClientsFromEcommerce (){

        SearchHelper::UsersActions();

        $directoryApp = App::basePath() . "\\storage\\app\\public\\generated_Files\\";
        if (!file_exists($directoryApp)) mkdir($directoryApp);
        $directoryEcommerceClients = App::basePath() . "\\storage\\app\\public\\generated_Files\\ecommerce_clients\\";
        if (!file_exists($directoryEcommerceClients)) mkdir($directoryEcommerceClients);

        $from = Carbon::today()->format(app('global_format_date')) . " 00:00:00";
        $to   = date(app('global_format_date').' 23:59:59');

        //$from = Carbon::today()->subDays(5)->format(app('global_format_date')) . " 00:00:00";
        //$to   = date(app('global_format_date').' 23:59:59');

        //$from = '2024-07-25 00:00:00';
        

        $sql="
            SET DATEFORMAT ymd 
            SELECT 
            top 100
            PH.cip as CIP ,
            PH.gerant_name as TITULAIRE ,
            PH.name as NOM_PHARMACIE ,
            PH.delivery_address_street as ADRESSE ,
            PH.delivery_address_zipcode as CP ,
            PH.delivery_address_town as VILLE ,
            PH.phone as TEL ,PH.fax as FAX ,
            PH.email as EMAIL ,
            'PHIE' as [TYPE], 
            '' as GRPT ,
            PH.bank_code as NBANQUE ,
            PH.guichet_code as NGUICHET ,
            PH.code_account_bank as NCOMPTE ,
            PH.rib as CLE_RIB ,
            PH.iban as IBAN ,
            PH.[UGA] ,
            PH.[SIRET] ,
            PH.[created_at] ,
            PH.[updated_at] ,
            PH.updated_at as DTE_MODIF ,
            PH.updated_at as DTE_MAJ_RIB ,
            PH.updated_at as DTE_CREA,
            PH.bank_name as BANK_NAME,
            PH.bic as BIC 
            FROM ECOMMERCE.[dbo].pharmacy as PH WHERE 
            ( (CONVERT(datetime, PH.[created_at]) BETWEEN '".$from."' AND '".$to."') 
             OR (CONVERT(datetime, PH.[updated_at]) BETWEEN '".$from."' AND '".$to."') ) 
             AND (iban IS NOT NULL AND iban <>'') AND (bank_code IS NOT NULL or bank_code <>'') 
             AND (guichet_code IS NOT NULL or guichet_code <>'') 
             AND (code_account_bank IS NOT NULL or code_account_bank <>'') AND (rib IS NOT NULL or rib <>'') AND country = '1'
        ";

        //echo ($sql);

        $clients = DB::connection('sqlsrv_ecommerce')->select($sql);

        $arr[] = array('CIP', 'TITULAIRE', 'NOM_PHARMACIE', 'ADRESSE', 'CP', 'VILLE', 'FAX', 'EMAIL', 'TYPE', 'GRPT'
        , 'NBANQUE', 'NGUICHET', 'NCOMPTE', 'CLE_RIB', 'IBAN', 'UGA', 'SIRET', 'created_at', 'updated_at', 'DTE_MODIF'
        , 'DTE_MAJ_RIB', 'DTE_CREA', 'BANK_NAME', 'BIC');

        $clients=array_map(function($item){
            return (array) $item;
        },$clients);

        foreach( $clients as $record ){
            $arr[] = $record;
        }

        $date = new DateTime();

        $fileName = $date->format("Ymd_His");

        $file = $directoryEcommerceClients . "CLIENTS_FROM_ECOMMERCE_" . $fileName . '.csv';

        SearchHelper::arrayToCSV($arr, $file);

        $mailInfo["txt"] = "Generated clients from ecommerce: " . ( count($arr) -1 );

        Mail::to(env('EMAIL_FOR_REPORTS'))->send(new ReportMail($mailInfo, $file, "CLIENTS_FROM_ECOMMERCE_" . $fileName . '.csv'));

    }

    public function updateAdareClients (){

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
        
        $local_path =  App::basePath() . "\\storage\\app\\temp\\" . 'UPDATE_CLIENT_ADARE_'.date('Ymd').'.csv';
        $remote_path = env('ADARE_FTP_DIR') . 'UPDATE_CLIENT_ADARE_'.date('Ymd').'.csv';
        //$remote_path = env('ADARE_FTP_DIR') . 'UPDATE_CLIENT_ADARE_'.date('Ymd', strtotime('-1 day')).'.csv';

        $res = Storage::disk('ftp_adare')->get($remote_path);
        
        if ( ! $res ){
            dump('updateAdareClients day file not found');
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('updateAdareClients day file not found'));
            return ;
        }
        
        Storage::put('/temp/' . 'UPDATE_CLIENT_ADARE_'.date('Ymd').'.csv', $res);

        $cnt = 0;
        $pharmaciesUpdated = array();
        $pharmaciesNotUpdated = array();

        if (($handle = fopen($local_path, "r")) !== FALSE) {
            while (($line = fgetcsv($handle, null, ";")) !== FALSE) {
                if($cnt != 0){
                    $farms = Pharmacy::where('cip', '=', $line[0])->get();
                    if(count($farms) > 0) {
                        foreach($farms as $pharmacy){
                            dump('Updating Pharmacy: ' . $pharmacy->name);
                            $farm_save = Pharmacy::find($pharmacy->id);
                            if ($line[1] != '')
                                $farm_save->name = $line[1];
                            if ($line[3] != '')
                                $farm_save->delivery_address_street = $line[3]; // address
                            if ($line[4] != '')
                                $farm_save->delivery_address_town = $line[4]; // ville
                            if ($line[5] != '')
                                $farm_save->delivery_address_zipcode = $line[5]; // cp
                            $farm_save->updated_at = date(app('global_format_date'));
                            $farm_save->save();
                            $pharmaciesUpdated[$farm_save->cip] = $farm_save;
                        }
                    } else {
                        $pharmaciesNotUpdated[$line[0]] = $line[1];
                    }
                }
                $cnt++;
            }
        }
        unlink($local_path);
        Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new PharmaciesModified($pharmaciesUpdated, $pharmaciesNotUpdated));
    }

    public function indexRecordingsFromHermes (){

        $days_done = '';
        $cnt = 0;

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));

        $conn_id = ftp_connect(env('HERMES_FTP_HOST'));
        $login_result = ftp_login($conn_id, env('HERMES_FTP_USER'), env('HERMES_FTP_PASS'));

        $directory = '\\RECORDS\\V5\\';

        $operations = Storage::disk('ftp_hermes')->directories($directory);

        foreach($operations as $opr){

            if ($opr == 'RECORDS/V5/PHARMA_VD_TERRAIN_SECTEUR3') {
                $cnt = SearchHelper::indexRecordings($opr, $conn_id);
            } // Opr
        }

        ftp_close($conn_id);

        dump('ended: ' . $days_done . ' - Records inserted: ' . $cnt);

        Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Ended indexRecordingsFromHermes: ' . $days_done . ' - Records inserted: ' . $cnt));
        Mail::to(env('EMAIL_FOR_TEST'))->send(new InfoMail('Ended indexRecordingsFromHermes: ' . $days_done . ' - Records inserted: ' . $cnt));


    }

    public function sendCustomerAcceptsMail(){

        DB::enableQueryLog();

        //$from = Carbon::today()->subDays(1)->toDateString() . " 00:00:00";
        $from = Carbon::today()->toDateString() . " 00:00:00";
        $text = 'needs atention';

        $tickets = Tickets::where('status_id', '=', "2")
                            ->where('level_a_id', '=', "1")
                            ->where('level_b_id', '=', "1")
                            ->where('level_c_id', '=', "2")
                            ->where('level_d_id', '=', "2")
                            ->whereNull('closingDate')
                            ->where('updated_at', '<=' , $from)
                            ->get();

        if( count($tickets) == 0){
            SearchHelper::DebuggerTxT("No tickets for sendCustomerAcceptsMail");
        }

        foreach($tickets as $ticket){

            if($ticket->department == "Legal"){
                Mail::to(env('EMAIL_FOR_LEGAL'))->send(new ReadingSaleRecord($ticket, $text));

                SearchHelper::DebuggerTxT("EMAIL_FOR_LEGAL");

            } else if($ticket->department == "AfterSales"){
                Mail::to(env('EMAIL_FOR_AFTERSALES'))->send(new ReadingSaleRecord($ticket, $text));

                SearchHelper::DebuggerTxT("EMAIL_FOR_AFTERSALES");

            } else if($ticket->department == "TI"){
                Mail::to(env('EMAIL_FOR_TI'))->send(new ReadingSaleRecord($ticket, $text));

                SearchHelper::DebuggerTxT("EMAIL_FOR_TI");

            } else if($ticket->department == "Logistics"){
                Mail::to(env('EMAIL_FOR_LOGISTICS'))->send(new ReadingSaleRecord($ticket, $text));

                SearchHelper::DebuggerTxT("EMAIL_FOR_LOGISTICS");

            }

        }

        SearchHelper::DebuggerTxT("Executed SQLs:");
        SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();
        DB::disableQueryLog();

    }

    /*

    La teoria es que en ecommerce se crea el pedido, los cambios de estado
    se obtienen desde Sage, creando primero el New cuando se lee el pedido inicial desde ecommerce
    y despues buscando los cambios de estado en Sage a Shipped o Invoiced

    Aunque parece que ahora hay dos nuevos estados
    Quoted, y uno del que aun no se la descripcion

    */

    public function getOrdersFromComandes (){

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
        echo('<pre>');

        DB::enableQueryLog();

        SearchHelper::DebuggerTxT("Init get Orders From Commandes");

        //$from = Carbon::today()->subMonth()->toDateString() . " 00:00:00";
        //$from = Carbon::today()->subDays(7)->toDateString() . " 00:00:00";

        $from = SearchHelper::convertirFechaParaSAGE(Carbon::today()->subDays(env('GET_ORDERS_FROM_DAYS'))->toDateString()) . " 00:00:00";
        $to = SearchHelper::convertirFechaParaSAGE(Carbon::today()->toDateString()) . " 23:59:59";

        $sql ="
            SELECT COM.NUM_COM as reference, PH.CIP, ph.NOM as pharmacyName, 'fr' as country,
            COM.DATE_LIVR as desiredDeliveryDate, COM.TA as agent_id,
            TA.LastName + ' ' + TA.FirstName as agent_name, FICHIER,
            COM.DATE_COMM, ph.EMAIL as pharmacyEmail, ph.CP as pharmacyCp, ph.TEL as pharmacyTel,
             ph.ADRESSE as pharmacyAddress, ph.VILLE as pharmacyVille
            FROM [COMMANDES].[dbo].[COMMANDES] COM
            JOIN [COMMANDES].[dbo].pharma_actives AS PH ON COM.CD_CLI = PH.CIP
            INNER JOIN [HN_Admin].[dbo].[Ident] T1 ON T1.Ident = COM.TA
			INNER JOIN [HN_Admin].[dbo].[HumanResource] TA ON TA.Oid = T1.Oid
            WHERE COM.DATE_COMM BETWEEN CONVERT(datetime, '". $from . "') AND CONVERT(datetime, '". $to . "')
            AND FICHIER IN ('AGINAX', 'BNSANTE_GC', 'THERAMEX1', 'LIFESTYLES', 'HAVEA_FR', 'ADARE')
        ";

echo($sql);
echo('<BR>');

        //return null;

        $orders_commandes = DB::connection('sqlsrv_commandes')->select($sql);

        foreach($orders_commandes as $order){

            $order_check = Orders::where('OrderNum', '=', $order->reference)->get();

            if ( Count($order_check) == 0 ){
                $order_save = New Orders();

                $order_save->sageStatus = 'New';


            } else {



                //DeV: Por los pedidos que me faltan, oon prod must be commented
                //ToDo: Now not updating due a server crash when running all
                if( ! env('UPDATE_COMMANDES_ORDERS') ){
                    echo('Skyppinig ' . $order_check[0]->OrderNum . '<HR>');
                    continue;
                }



                //echo("Existe pedido - order_check[0]->id: " . $order_check[0]->id . "<HR>");
                $latsOrderID = $order_check[0]->id;

                $order_save = Orders::find($order_check[0]->id);

                $order_save->updated_at = date(app('global_format_date'));

            }

            // Now we save in a new created object or in an existing one

            $order_save->OrderNum = $order->reference;
            $order_save->CIP = $order->CIP;

            $order_save->pharmacyName = $order->pharmacyName;

            $order_save->country = $order->country;



            $order_save->desiredDeliveryDate = $order->desiredDeliveryDate;

            $order_save->agent_id = $order->agent_id;
            $order_save->agent_name = $order->agent_name;


            $order_save->total = 0;

            $order_save->orderDate = $order->DATE_COMM;
            $order_save->zipCode = $order->pharmacyCp;
            $order_save->telephone = $order->pharmacyTel;
            $order_save->email = $order->pharmacyEmail;
            $order_save->fichier = trim($order->FICHIER);
            $order_save->address = $order->pharmacyAddress;
            $order_save->city = $order->pharmacyVille;

            $order_save->created_at = date(app('global_format_date'));
            $order_save->updated_at = date(app('global_format_date'));

            $order_save->save();





            //DeV: Remove this on production
            //continue;





            $latsOrderID = $order_save->id;

            $sql = "SELECT CD_ART as product_id, QTE_ART as quantity, PHT_U as price, REM as discount
                    FROM COMMANDES.DBO.ARTICLE_COMM ART WHERE NUM_COM = '" . $order->reference . "'";


            $order_items = DB::select($sql);

            foreach($order_items as $value_item){

                // OrdrItems Model from Pilot
                $item_check = OrderItems::where('product_id', '=', $value_item->product_id)
                                        ->where('OrderNum', '=', $order->reference)
                                        ->get();

                if ( Count($item_check) == 0 ){
                    $item = new OrderItems();
                    $item->orders_id = $latsOrderID;
                    //echo("order_save->id: " . $latsOrderID . "<HR>");
                } else {
                    $item = OrderItems::find($item_check[0]->id);
                }

                $item->OrderNum = $order->reference;

                $item->product_id = $value_item->product_id;

                //SearchHelper::DebuggerVar("quantity", $value_item->quantity);
                //SearchHelper::DebuggerVar("price", $value_item->price);

                $item->quantity = $value_item->quantity;
                $item->price = number_format($value_item->price, 2, '.', '');

                //SearchHelper::DebuggerVar("price 2", $item->price);

                $item->discount = number_format($value_item->discount, 2, '.', '');

                $sql = "SELECT LIB_ART AS name, CIP13, LABO, CD_ART FROM COMMANDES.DBO.ARTICLES WHERE CD_ART = '" . $value_item->product_id . "'";

                $product = DB::select($sql);

                if (Isset($product[0])){
                    $item->product_name = $product[0]->name;

                    //$item->product_reference = $product[0]->CD_ART;
                }

                //ToDo: What will be the product reference
                if (!empty($product[0]->CD_ART)) {
                    $item->product_reference = trim($product[0]->CD_ART);
                } else {
                    //ToDo: Acciones a realizar si $product->sku está vacío
                }


                // ToDo: Get laboratory name from empty field, but by now the only one

                $item->product_laboratory = trim($order->FICHIER);

                //$item->total = (($item->price - $item->discount) * $item->quantity);

                $item->total = ( $item->price * $item->quantity ) - ( $item->price * $item->quantity * $item->discount / 100 );

                $item->created_at = date(app('global_format_date'));
                $item->updated_at = date(app('global_format_date'));

                $item->save();

            }

            // $order_check viene de la comprobacion inicial para ver si hay pedido,
            // inserto aqui el delivery porque me hace falta orders_id, que lo guardamos en $latsOrderID
            // que se genera cuando ha encontrado el pedido y lo ha actualizado o a salvado el nuevo

            if ( Count($order_check) == 0 ){
                // ToDo: Insert the first delivery record "New"
                $delivery = new Delivery();
                $delivery->orders_id = $latsOrderID;
                $delivery->orderNum = $order->reference;
                $delivery->created_at = date(app('global_format_date'));
                $delivery->updated_at = date(app('global_format_date'));
                $delivery->save();
            }
        }

        SearchHelper::DebuggerTxT("Executed SQLs:");
        SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();
        DB::disableQueryLog();

        //echo("</pre>");

        Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Ended getOrdersFromComandes'));

    }


    public function getOrdersFromEcommerce (){

        DB::enableQueryLog();
        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
        echo('<pre>');

        SearchHelper::DebuggerTxT("Init getOrdersFromEcommerce");

        // Get eccomerce orders


        //DeV: Order´s date carbon options
        //$from = Carbon::today()->subMonth()->toDateString() . " 00:00:00";
        //$from = Carbon::today()->subDays(env('GET_ORDERS_FROM_DAYS'))->toDateString() . " 00:00:00";

        //$from = Carbon::today()->toDateString() . " 00:00:00";
        //$to = Carbon::today()->toDateString() . " 23:59:59";

        $from = "20241014 00:00:00";
        $to = "20241015 23:59:59";



        $orders_ecommerce = Order::orderBy('reference')
                                    //DeV: Choose check only for the actual day
                                    ->whereBetween('updated_at', [$from, $to])
                                    ->where('status', 'confirmed')
                                    ->with('pharmacy')
                                    ->with('tele_operator')
                                    ->get();

        //var_dump($orders_ecommerce);

        foreach($orders_ecommerce as $order){

            $order_check = Orders::where('OrderNum', '=', $order->reference)->get();

            if ( Count($order_check) == 0 ){
                $order_save = New Orders();

                $order_save->sageStatus = 'New';


            } else {

                echo("Order exists: " . $order_check[0]->OrderNum . "<HR>");

                //ToDo: Now not updating due a server crash when running all
                if( ! env('UPDATE_ECOMMERCE_ORDERS') ){
                    echo('Skyppinig ' . $order_check[0]->OrderNum . '<HR>');
                    continue;
                }

                $latsOrderID = $order_check[0]->id;

                $order_save = Orders::find($order_check[0]->id);

                $order_save->updated_at = date(app('global_format_date'));

            }

            // Now we save in a new created object or in an existing one

            $order_save->OrderNum = $order->reference;
            $order_save->CIP = $order->pharmacy->cip;

            $order_save->pharmacyName = $order->pharmacy->name;

            $order_save->country = 'fr';



            $order_save->desiredDeliveryDate = $order->desired_delivery_date;

            $order_save->agent_id = $order->tele_operator_id;
            $order_save->agent_name = $order->tele_operator->getFullName();

            $order_save->total = 0;

            $order_save->orderDate = $order->created_at;
            $order_save->zipCode = $order->pharmacy->cip;
            $order_save->telephone = $order->pharmacy->phone;
            $order_save->email = $order->pharmacy->email;

            $order_save->address = $order->pharmacy->delivery_address_street;
            $order_save->city = $order->pharmacy->delivery_address_town;

            $order_save->fichier = 'AGINAX';

            $order_save->created_at = date(app('global_format_date'));
            $order_save->updated_at = date(app('global_format_date'));

            $order_save->save();

            $latsOrderID = $order_save->id;

            echo("latsOrderID: " . $order_save->id . "<HR>");

            // Order Items from ecommerce, ORderDetail is a Model from Ecommerce project
            $order_items = OrderDetail::where('order_id', '=', $order->id)->get();

            echo("Buscando items de: " . $order->id . "<HR>");

            foreach($order_items as $key_i => $value_item){

                // OrdrItems Model from Pilot
                $item_check = OrderItems::where('product_id', '=', $value_item->product_id)
                                        ->where('OrderNum', '=', $order->reference)
                                        ->get();

                if ( Count($item_check) == 0 ){
                    $item = new OrderItems();
                    $item->orders_id = $latsOrderID;
                    echo("order_save->id: " . $latsOrderID . "<HR>");
                } else {
                    $item = OrderItems::find($item_check[0]->id);
                }

                $item->OrderNum = $order->reference;
                $item->product_id = $value_item->product_id;
                $item->quantity = $value_item->quantity;
                $item->price = $value_item->price;
                $item->discount = $value_item->discount;

                //ToDo: What if there is no product, imposible, but ...
                $product = Product::find($value_item->product_id);

                $item->product_name = $product->name;

                //ToDo: What will be the product reference
                if (!empty($product->sku)) {
                    $item->product_reference = $product->sku;
                } else {
                    //ToDo: Acciones a realizar si $product->sku está vacío
                }

                $item->product_laboratory = $product->laboratory->name;

                $item->total = ( $item->price * $item->quantity ) - ( $item->price * $item->quantity * $item->discount / 100 );

                $item->created_at = date(app('global_format_date'));
                $item->updated_at = date(app('global_format_date'));

                $item->save();

            }

            // $order_check viene de la comprobacion inicial para ver si hay pedido,
            // inserto aqui el delivery porque me hace falta orders_id, que lo guardamos en $latsOrderID
            // que se genera cuando ha encontrado el pedido y lo ha actualizado o a salvado el nuevo

            if ( Count($order_check) == 0 ){
                // ToDo: Insert the first delivery record "New"
                $delivery = new Delivery();
                $delivery->orders_id = $latsOrderID;
                $delivery->orderNum = $order->reference;
                $delivery->created_at = date(app('global_format_date'));
                $delivery->updated_at = date(app('global_format_date'));
                $delivery->save();
            }
        }

        SearchHelper::DebuggerTxT("Executed SQLs:");
        SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();
        DB::disableQueryLog();

        echo("</pre>");

        Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Ended getOrdersFromEcommerce'));
    }

    /*
        DO_TYPE is the order status
            0: canceled
            1: "awaiting processiong"
            3 : being processed
            7 : shipped

            status 0 is well canceled (editado)

            status 1: order "awaiting processing" (for purchase order)


    */

    public function getOrdersFromSage(){

        DB::enableQueryLog();

        SearchHelper::DebuggerTxT("Init getOrdersFromSage");

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
        echo('<pre>');

        $from = SearchHelper::convertirFechaParaSAGE(Carbon::today()->subDays(env('GET_ORDERS_FROM_DAYS'))->toDateString()) . " 00:00:00";
        $to = SearchHelper::convertirFechaParaSAGE(Carbon::today()->toDateString()) . " 23:59:59";

        //$from = '01-01-2023 00:00:00';
        //$to = '31-12-2023 23:59:59';

        $orders_sage_cancelled = SearchHelper::getSageOrdersFromStatus('0', $from, $to);

        //DeV: Force use an order number
        //$orders_sage_cancelled = DB::connection('sqlsrv_sage')->table('C_BN_SANTE.dbo.F_DOCENTETE')->select("DO_Ref as reference")->where('DO_Ref', '=', '1206132')->get();

        foreach($orders_sage_cancelled as $order){

            SearchHelper::DebuggerTxT('Cancelled Order Number: ' . $order->reference);

            //DeV: Force use an order number
            //$order->reference = '1300036';

            if (trim($order->reference) == '') continue;

            $order_check = Orders::where('OrderNum', '=', $order->reference)->get();

            if ( Isset($order_check[0]) ){
                $text = 'Update order at sage 1: ' . $order->reference ;
                SearchHelper::DebuggerTxT($text);

                $order_save = Orders::find($order_check[0]->id);
                $order_save->sageStatus = 'Cancelled';
                $order_save->save();
            } else {
                $text = 'Missing order at sage 1: ' . $order->reference ;
                SearchHelper::DebuggerTxT($text);
                //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
            }
        }

        // Get todays orders with status 1, what means Shipped
        $orders_sage_shipped = SearchHelper::getSageOrdersFromStatus('7', $from, $to);

        //DeV: Force use an order number
        //$orders_sage_shipped = DB::connection('sqlsrv_sage')->table('C_BN_SANTE.dbo.F_DOCENTETE')->select("DO_Ref as reference")->where('DO_Ref', '=', '1206132')->get();

        foreach($orders_sage_shipped as $order){

            SearchHelper::DebuggerTxT('Shipped Order Number: ' . $order->reference);

            //DeV: Force use an order number
            //$order->reference = '1300036';

            if (trim($order->reference) == '') continue;

            $order_check = Orders::where('OrderNum', '=', $order->reference)->get();

            if ( Isset($order_check[0]) ){
                $text = 'Update order at sage 2: ' . $order->reference ;
                SearchHelper::DebuggerTxT($text);

                $order_save = Orders::find($order_check[0]->id);
                $order_save->sageStatus = 'Shipped';
                $order_save->save();
            } else {
                $text = 'Missing order at sage 2: ' . $order->reference ;
                SearchHelper::DebuggerTxT($text);
                //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
            }
        }

        $orders_sage_preparing = SearchHelper::getSageOrdersFromStatus('1', $from, $to);

        //DeV: Force use an order number
        //$orders_sage_invoiced = DB::connection('sqlsrv_sage')->table('C_BN_SANTE.dbo.F_DOCENTETE')->select("DO_Ref as reference")->where('DO_Ref', '=', '1206132')->get();


        foreach($orders_sage_preparing as $order){

            SearchHelper::DebuggerTxT('Preparing Order Number: ' . $order->reference);

            //DeV: Force use an order number
            //$order->reference = '1300036';

            if (trim($order->reference) == '') continue;

            $order_check = Orders::where('OrderNum', '=', $order->reference)->get();

            if ( Isset($order_check[0]) ){
                $text = 'Update order at sage 3: ' . $order->reference ;
                SearchHelper::DebuggerTxT($text);

                $order_save = Orders::find($order_check[0]->id);
                $order_save->sageStatus = 'Preparing';
                $order_save->save();
            } else {
                $text = 'Missing order at sage 3: ' . $order->reference ;
                SearchHelper::DebuggerTxT($text);
                //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
            }
        }

        SearchHelper::DebuggerTxT("Executed SQLs:");
        SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();
        DB::disableQueryLog();

        echo("</pre>");

        Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Ended getOrdersFromSage'));

    }

    public function getOrdersFromCMC(){

        DB::enableQueryLog();

        SearchHelper::DebuggerTxT("Init getOrdersFromSage");

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
        echo('<pre>');

        $from = SearchHelper::convertirFechaParaSAGE(Carbon::today()->subDays(env('GET_ORDERS_FROM_DAYS'))->toDateString()) . " 00:00:00";
        $to = SearchHelper::convertirFechaParaSAGE(Carbon::today()->toDateString()) . " 23:59:59";

        //$from = '01-01-2023 00:00:00';
        //$to = '31-12-2023 23:59:59';

        $orders_sage_cancelled = SearchHelper::getCMCOrdersFromStatus('0', $from, $to);

        //DeV: Force use an order number
        //$orders_sage_cancelled = DB::connection('sqlsrv_sage')->table('C_BN_SANTE.dbo.F_DOCENTETE')->select("DO_Ref as reference")->where('DO_Ref', '=', '1206132')->get();

        foreach($orders_sage_cancelled as $order){

            SearchHelper::DebuggerTxT('Cancelled Order Number: ' . $order->reference);

            //DeV: Force use an order number
            //$order->reference = '1300036';

            if (trim($order->reference) == '') continue;

            $order_check = Orders::where('OrderNum', '=', $order->reference)->get();

            if ( Isset($order_check[0]) ){
                $order_save = Orders::find($order_check[0]->id);
                $order_save->sageStatus = 'Cancelled';
                $order_save->save();
            } else {
                $text = 'Missing order at sage 1: ' . $order->reference ;
                SearchHelper::DebuggerTxT($text);
                //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
            }
        }

        // Get todays orders with status 1, what means Shipped
        $orders_sage_shipped = SearchHelper::getCMCOrdersFromStatus('7', $from, $to);

        //DeV: Force use an order number
        //$orders_sage_shipped = DB::connection('sqlsrv_sage')->table('C_BN_SANTE.dbo.F_DOCENTETE')->select("DO_Ref as reference")->where('DO_Ref', '=', '1206132')->get();

        foreach($orders_sage_shipped as $order){

            SearchHelper::DebuggerTxT('Shipped Order Number: ' . $order->reference);

            //DeV: Force use an order number
            //$order->reference = '1300036';

            if (trim($order->reference) == '') continue;

            $order_check = Orders::where('OrderNum', '=', $order->reference)->get();

            if ( Isset($order_check[0]) ){
                $order_save = Orders::find($order_check[0]->id);
                $order_save->sageStatus = 'Shipped';
                $order_save->save();
            } else {
                $text = 'Missing order at sage 2: ' . $order->reference ;
                SearchHelper::DebuggerTxT($text);
                //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
            }
        }

        $orders_sage_preparing = SearchHelper::getCMCOrdersFromStatus('1', $from, $to);

        //DeV: Force use an order number
        //$orders_sage_invoiced = DB::connection('sqlsrv_sage')->table('C_BN_SANTE.dbo.F_DOCENTETE')->select("DO_Ref as reference")->where('DO_Ref', '=', '1206132')->get();


        foreach($orders_sage_preparing as $order){

            SearchHelper::DebuggerTxT('Preparing Order Number: ' . $order->reference);

            //DeV: Force use an order number
            //$order->reference = '1300036';

            if (trim($order->reference) == '') continue;

            $order_check = Orders::where('OrderNum', '=', $order->reference)->get();

            if ( Isset($order_check[0]) ){
                $order_save = Orders::find($order_check[0]->id);
                $order_save->sageStatus = 'Preparing';
                $order_save->save();
            } else {
                $text = 'Missing order at sage 3: ' . $order->reference ;
                SearchHelper::DebuggerTxT($text);
                //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
            }
        }

        SearchHelper::DebuggerTxT("Executed SQLs:");
        SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();
        DB::disableQueryLog();

        echo("</pre>");

        Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Ended getOrdersFromCMC'));

    }

    public function getRecordingsFroHermes(){

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
        echo('<pre>');

        DB::enableQueryLog();

        $from = SearchHelper::convertirFechaParaSAGE(Carbon::today()->subDays(env('GET_ORDERS_FROM_DAYS_HERMES'))->toDateString()) . " 00:00:00";
        $to = SearchHelper::convertirFechaParaSAGE(Carbon::today()->toDateString()) . " 23:59:59";

        //$from = '01-01-2023 00:00:00';
        //$to = '31-12-2023 23:59:59';
        // FICHIER IN ('AGINAX', 'BNSANTE_GC', 'ALFASIGMA1','THERAMEX1', 'LIFESTYLES', 'HAVEA_BL', 'NEOPULSE')

        $sql ="
        SELECT NUM_COM as order_number, Rec_Filename as fileName
        FROM COMMANDES.DBO.COMMANDES T1
        INNER JOIN HN_Ondata.DBO.Record T2
        ON T1.TA = T2.Rec_AgentId
        WHERE FICHIER IN ('AGINAX', 'THERAMEX1', 'ADARE', 'HAVEA_FR', 'LIFESTYLES') AND
        VALIDEE IN ('Y', 'PY')
        AND CD_CLI = T2.Rec_IdLink
        --AND t2.REC_DATE BETWEEN CONVERT(datetime, '".$from."') AND CONVERT(datetime, '".$to."')
         --AND MONTH(T1.DATE_COMM) = MONTH(REC_DATE)
        --AND YEAR(T1.DATE_COMM) = YEAR(REC_DATE)
		AND MONTH(T1.DATE_COMM) = '07'
        AND YEAR(T1.DATE_COMM) = '2024'
        AND T1.GRD_COMPTE is null
        UNION
        SELECT NUM_COM as order_number, Rec_Filename as fileName
        FROM COMMANDES.DBO.COMMANDES T1
        INNER JOIN ARCHIVES.DBO.Record_2022 T2
        ON T1.TA = T2.Rec_AgentId
        WHERE FICHIER IN ('AGINAX', 'THERAMEX1', 'ADARE', 'HAVEA_FR', 'LIFESTYLES') AND
        VALIDEE IN ('Y', 'PY')
         --AND MONTH(T1.DATE_COMM) = MONTH(REC_DATE)
        --AND YEAR(T1.DATE_COMM) = YEAR(REC_DATE)
		AND MONTH(T1.DATE_COMM) = '07'
        AND YEAR(T1.DATE_COMM) = '2024'
        AND CD_CLI = T2.Rec_IdLink
        --AND t2.REC_DATE BETWEEN CONVERT(datetime, '".$from."') AND CONVERT(datetime, '".$to."')
        AND T1.GRD_COMPTE is null
        UNION
        SELECT NUM_COM as order_number, Rec_Filename as fileName
        FROM COMMANDES.DBO.COMMANDES T1
        INNER JOIN ARCHIVES.DBO.Record_2023 T2
        ON T1.TA = T2.Rec_AgentId
        WHERE FICHIER IN ('AGINAX', 'THERAMEX1', 'ADARE', 'HAVEA_FR', 'LIFESTYLES') AND
        VALIDEE IN ('Y', 'PY')
        --AND MONTH(T1.DATE_COMM) = MONTH(REC_DATE)
        --AND YEAR(T1.DATE_COMM) = YEAR(REC_DATE)
		AND MONTH(T1.DATE_COMM) = '07'
        AND YEAR(T1.DATE_COMM) = '2024'
        AND CD_CLI = T2.Rec_IdLink
        --AND t2.REC_DATE BETWEEN CONVERT(datetime, '".$from."') AND CONVERT(datetime, '".$to."')
        AND T1.GRD_COMPTE is null
		 UNION
		 SELECT reference as order_number, Rec_Filename as fileName
        FROM ECOMMERCE.DBO.[order] T1
		INNER JOIN ECOMMERCE.DBO.tele_operator T3
		ON T3.id = T1.tele_operator_id
		INNER JOIN ECOMMERCE.DBO.pharmacy T4
		ON T4.id = T1.pharmacy_id
        INNER JOIN HN_Ondata.DBO.Record T2
        ON T3.operator_id = T2.Rec_AgentId
        WHERE T1.status = 'confirmed'
        --AND MONTH(T1.created_at) = MONTH(REC_DATE)
        --AND YEAR(T1.created_at) = YEAR(REC_DATE)
		AND MONTH(T1.created_at) = '07'
        AND YEAR(T1.created_at) = '2024'
        AND T4.cip = T2.Rec_IdLink
        --AND t2.REC_DATE BETWEEN CONVERT(datetime, '".$from."') AND CONVERT(datetime, '".$to."')
		UNION
		 SELECT reference as order_number, Rec_Filename as fileName
        FROM ECOMMERCE.DBO.[order] T1
		INNER JOIN ECOMMERCE.DBO.tele_operator T3
		ON T3.id = T1.tele_operator_id
		INNER JOIN ECOMMERCE.DBO.pharmacy T4
		ON T4.id = T1.pharmacy_id
        INNER JOIN ARCHIVES.DBO.Record_2022 T2
        ON T3.operator_id = T2.Rec_AgentId
        WHERE T1.status = 'confirmed'
        --AND MONTH(T1.created_at) = MONTH(REC_DATE)
        --AND YEAR(T1.created_at) = YEAR(REC_DATE)
		AND MONTH(T1.created_at) = '07'
        AND YEAR(T1.created_at) = '2024'
        AND T4.cip = T2.Rec_IdLink
        --AND t2.REC_DATE BETWEEN CONVERT(datetime, '".$from."') AND CONVERT(datetime, '".$to."')
		UNION
		 SELECT reference as order_number, Rec_Filename as fileName
        FROM ECOMMERCE.DBO.[order] T1
		INNER JOIN ECOMMERCE.DBO.tele_operator T3
		ON T3.id = T1.tele_operator_id
		INNER JOIN ECOMMERCE.DBO.pharmacy T4
		ON T4.id = T1.pharmacy_id
        INNER JOIN ARCHIVES.DBO.Record_2023 T2
        ON T3.operator_id = T2.Rec_AgentId
        WHERE T1.status = 'confirmed'
        --AND MONTH(T1.created_at) = MONTH(REC_DATE)
        --AND YEAR(T1.created_at) = YEAR(REC_DATE)
		AND MONTH(T1.created_at) = '07'
        AND YEAR(T1.created_at) = '2024'
        AND T4.cip = T2.Rec_IdLink
        --AND t2.REC_DATE BETWEEN CONVERT(datetime, '".$from."') AND CONVERT(datetime, '".$to."')
";

        //echo($sql);

        //return null;
/*
        $sql ="
                SELECT NUM_COM as order_number, Rec_Filename as fileName
                FROM COMMANDES.DBO.COMMANDES T1
                INNER JOIN HN_Ondata.DBO.Record T2
                ON T1.TA = T2.Rec_AgentId
                WHERE
                FICHIER  = 'AGINAX' AND
                VALIDEE IN ('Y', 'PY')
                AND CONVERT(date, DATE_COMM) = REC_DATE
                AND CD_CLI = T2.Rec_IdLink
                AND t2.REC_DATE BETWEEN CONVERT(datetime, '".$from."') AND CONVERT(datetime, '".$to."')
        ";

        $sql ="
                SELECT TOP 3 '1206132' as order_number, Rec_Filename as fileName
                FROM COMMANDES.DBO.COMMANDES T1
                INNER JOIN HN_Ondata.DBO.Record T2
                ON T1.TA = T2.Rec_AgentId
                WHERE FICHIER  = 'AGINAX'
                AND VALIDEE IN ('Y', 'PY')
                AND CONVERT(date, DATE_COMM) = REC_DATE
                AND CD_CLI = T2.Rec_IdLink
        ";

$sql ="
    SELECT NUM_COM as order_number, Rec_Filename as fileName
    FROM COMMANDES.DBO.COMMANDES T1
    INNER JOIN HN_Ondata.DBO.Record T2
    ON T1.TA = T2.Rec_AgentId2
    WHERE FICHIER  = 'AGINAX'
    AND VALIDEE IN ('Y', 'PY')
    AND CONVERT(date, DATE_COMM) = REC_DATE
    AND CD_CLI = T2.Rec_IdLink
    AND NUM_COM = '1189665'
        ";
*/

        foreach( DB::connection('sqlsrv_commandes')->select($sql) as $record ){

            $fileName = substr($record->fileName, strrpos($record->fileName, "\\")+1);

            SearchHelper::DebuggerTxT("Start Order number: " . $record->order_number . " - File: " . $fileName);

            $record_check = Recordings::where('order_number', '=', $record->order_number)
                                        ->where('fileName', '=', $fileName)
                                        ->get();

            $recordings_count = Recordings::where('order_number', '=', $record->order_number)->get();

            SearchHelper::DebuggerTxT("Founded recording: " . $record->fileName);

            if ( ! Count($record_check)){

                $order = Orders::where('OrderNum', '=', $record->order_number)->get();
                if(count($order)){

                    $nasPath = str_replace("d:\\hermes_p\\Files\\454547A4A436D434\\RECORDS\\", env('HERMES_PATH'), $record->fileName) ;

                    $ftpPath = str_replace("d:\\hermes_p\\Files\\454547A4A436D434\\RECORDS\\", '/RECORDS/V5/', $record->fileName) ;

                    $ftpPath = str_replace("\\", "/", $ftpPath);

                    SearchHelper::DebuggerTxT($nasPath);

                    $partes_ruta = pathinfo($nasPath);

                    echo $partes_ruta['dirname'] . "<br>";
                    //echo $partes_ruta['basename'], "\n";
                    //echo $partes_ruta['extension'], "\n";
                    //echo $partes_ruta['filename'], "\n";

                    SearchHelper::DebuggerVar('ftpPath', 'ftp://RECORDS:ed45K_d4U@172.20.0.79' . $ftpPath);


                    if(Storage::disk('ftp_hermes')->exists($ftpPath)){
                    //if(is_file($nasPath)){
                    //if (file_exists($nasPath)){

                        $record_save = new Recordings();

                        $record_save->orders_id = $order[0]->id;
                        $record_save->order_number = $record->order_number;
                        $record_save->fileName = $fileName;
                        $record_save->nasPath = $ftpPath;

                        $record_save->created_at = date(app('global_format_date'));
                        $record_save->updated_at = date(app('global_format_date'));
                        $record_save->save();

                        $text = 'Added File from hermes for order number: ' . $record->order_number ;
                        SearchHelper::DebuggerTxT($text);

                        //$directoryApp = App::basePath() . "\\storage\\app\\public\\recordings_uploads\\";
                        //$directoryBase = App::basePath() . "\\storage\\app\\public\\recordings_uploads\\" . $order[0]->id . "\\";
                        //$directory = App::basePath() . "\\storage\\app\\public\\recordings_uploads\\" . $order[0]->id . "\\" . $record_save->id . "\\";
                        //if (!file_exists($directoryApp)) mkdir($directoryApp);
                        //if (!file_exists($directoryBase)) mkdir($directoryBase);
                        //if (!file_exists($directory)) mkdir($directory);
                        //copy($nasPath, $directory . $fileName);

                    } else {
                        $text = 'Missing File at hermes for order number: ' . $record->order_number ;
                        SearchHelper::DebuggerTxT($text);
                        //DeV: To many emails in dev
                        //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
                    }
                } else {
                    $text = 'Missing order at commandes: ' . $record->order_number ;
                    SearchHelper::DebuggerTxT($text);
                    //DeV: To many emails in dev
                    //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
                }
            } else {
                SearchHelper::DebuggerTxT("Already added: " . $fileName);
            }
        }

        SearchHelper::DebuggerTxT("Executed SQLs:");
        SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();
        DB::disableQueryLog();

        echo("</pre>");

        Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Ended getRecordingsFroHermes'));

   }

   public function getProofOfDeliveries (){

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
        echo('<pre>');

        SearchHelper::DebuggerTxT("Starting getProofOfDeliveries");

        DB::enableQueryLog();

        $directory = App::basePath() . "\\storage\\app\\public\\proof_drop\\already_loaded";
        if (!file_exists($directory)) mkdir($directory);
        $directory = App::basePath() . "\\storage\\app\\public\\proof_drop\\not_found";
        if (!file_exists($directory)) mkdir($directory);
        $directory = App::basePath() . "\\storage\\app\\public\\proof_drop\\wrong_extension";
        if (!file_exists($directory)) mkdir($directory);


        $files = Storage::allFiles("public\\proof_drop");

        // The pathinfo() will gives you the output:
        // { "dirname":"file_path", "basename":"file_name.file_extension", "extension":"file_extension", "filename":"file_name" }

        foreach($files as $pathOrigin) {

            if (  pathinfo($pathOrigin)['extension'] != "pdf" ){
                SearchHelper::DebuggerTxT("Wrong extension file at folder: " . pathinfo($pathOrigin)['basename']);
                $moveFile = App::basePath() . "\\storage\\app\\public\\proof_drop\\wrong_extension\\" . pathinfo($pathOrigin)['basename'];
                rename(App::basePath() . "\\storage\\app\\" . $pathOrigin, $moveFile);
                continue;
            }

            //$file = pathinfo($pathOrigin);

            $colisNum = pathinfo($pathOrigin)['filename'];

            //ToDo: Esta relacion es complicada
            // First search for an order with the tracking number
            $order = Orders::where('colisNum', '=', $colisNum)->get();

            if (Isset($order[0]->id)){

                // If founded, search for a DeliveryFile for that order
                $deliveryFile = DeliveryFiles::where('orders_id', '=', $order[0]->id)->get();


                if( count($deliveryFile) ){
                    // If founded do nothing
                    SearchHelper::DebuggerTxT( "Founded delivery record for " . $order[0]->OrderNum . " Tracking number: " . $colisNum ) ;
                    $moveFile = App::basePath() . "\\storage\\app\\public\\proof_drop\\already_loaded\\" . pathinfo($pathOrigin)['basename'];
                    rename(App::basePath() . "\\storage\\app\\" . $pathOrigin, $moveFile);
                    //$file = DeliveryFiles::find($deliveryFile[0]->id);
                    continue;
                }

                SearchHelper::DebuggerTxT( "Creating delivery record for " . $order[0]->OrderNum ) ;
                $file = new DeliveryFiles();

                $file->orders_id = $order[0]->id;
                $file->fileName = pathinfo($pathOrigin)['basename'];

                $file->save();

                $destination = App::basePath() . '\\storage\\app\\public\\proof_uploads\\' . $order[0]->id .'/' . $file->id . "/" . pathinfo($pathOrigin)['basename'] ;

                $directoryApp = App::basePath() . "\\storage\\app\\public\\proof_uploads\\";
                $directoryBase = App::basePath() . "\\storage\\app\\public\\proof_uploads\\" . $order[0]->id . "\\";
                $directory = App::basePath() . "\\storage\\app\\public\\proof_uploads\\" . $order[0]->id . "\\" . $file->id . "\\";

                if (!file_exists($directoryApp)) mkdir($directoryApp);

                if (!file_exists($directoryBase)) mkdir($directoryBase);

                if (!file_exists($directory)) mkdir($directory);

                $pathOrigin = App::basePath() . "\\storage\\app\\" . $pathOrigin;

                SearchHelper::DebuggerVar("Origen", $pathOrigin);
                SearchHelper::DebuggerVar("Destination", $destination);

                copy( $pathOrigin, $destination );

                unlink( $pathOrigin );

            } else {

                $text = 'Missing order with tracking number: ' . $colisNum ;
                SearchHelper::DebuggerTxT($text);

                $moveFile = App::basePath() . "\\storage\\app\\public\\proof_drop\\not_found\\" . pathinfo($pathOrigin)['basename'];
                rename(App::basePath() . "\\storage\\app\\" . $pathOrigin, $moveFile);
                //DeV: To many emails in dev
                //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));

            }
        }

        SearchHelper::DebuggerTxT("Executed SQLs:");
        SearchHelper::bindBuilderQuery(DB::getQueryLog());

        DB::flushQueryLog();
        DB::disableQueryLog();


        echo("</pre>");

        Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Ended getProofOfDeliveries'));

   }

    public function deleteTempRecordings (){

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
        echo('<pre>');

        SearchHelper::DebuggerTxT("Starting deleteTempRecordings");

        DB::enableQueryLog();

        $directory = "public\\tmp";
        $files = Storage::allFiles($directory);

        // The pathinfo will gives you the output:
        // { "dirname":"file_path", "basename":"file_name.file_extension", "extension":"file_extension", "filename":"file_name" }

        foreach($files as $pathOrigin) {

            $recording = App::basePath() . "\\storage\\app\\" . $pathOrigin;
            SearchHelper::DebuggerTxT("Path to delete: " . $recording);
            unlink( $recording );
        }


        echo("</pre>");

        Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Ended deleteTempRecordings'));

   }
}
