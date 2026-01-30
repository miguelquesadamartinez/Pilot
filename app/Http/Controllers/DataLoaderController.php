<?php

namespace App\Http\Controllers;

use App\Helpers\SearchHelper;
use App\Mail\InfoMail;
use App\Models\Orders;
use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Models\DeliveryFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DataLoaderController extends Controller
{
    public function sage(){

        $orders = DB::connection('sqlsrv_sage')
                    ->select("
                        SELECT
                            LIGNE.DO_Ref as REFERENCE_ODOO,
                            LIGNE.DO_Piece as Num_SAGE ,
                            AR_Ref as Produit,
                            DL_Design as Libelle,
                            DL_Qte as QUANTITE,
                            DO_TOTALHT as CAR,
                            LIGNE.DO_Date as Date_Commande,
                            Depot.DE_Intitule as Dépot,
                            Dépositaire,
                            LIGNE.DO_DateLivr as date_Liv_Prevue,
                            Ligne.CT_Num as CIP,
                            Client.CT_Intitule as Nom_Pharmacie,
                            CT_Adresse as Adresse,
                            CT_CodePostal as Code_Postal,
                            CT_Ville as Ville
                        FROM F_DOCLIGNE as Ligne
                        INNER JOIN F_DEPOT as Depot ON Ligne.DE_No = Depot.DE_No
                        INNER JOIN F_COMPTET as CLIENT on CLIENT.CT_Num = LIGNE.CT_Num
                        INNER JOIN F_DOCENTETE as ENTETE on ENTETE.DO_Piece = LIGNE.DO_Piece
                        WHERE LIGNE.DO_type in (1)
                        ORDER BY LIGNE.DO_DateLivr ASC
                    ");

        return view('admin.dataloader.sage')->with('orders', $orders);

    }

    public function sendSage(Request $request) {

        $validatedData = $request->validate([
            'sage_file' => 'required|mimes:txt,csv|max:10',
        ]);


        if ($request->hasFile('sage_file')) {
            $file = $request->file('sage_file');
            
            if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
                while (($line = fgets($handle)) !== false) {
                    echo($line . '<BR>');
                }
            }
            
           
        }

        return back()->with('success', 'File uploaded successfully.')->withInput();

    }

    public function gls(){

        return view('admin.dataloader.gls');

    }

    public function sendGls(Request $request) {

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));

        $return_array_not_found = null;

        $validatedData = $request->validate([
            'gls_file' => 'required|mimes:txt,csv',
        ]);

        if ($request->hasFile('gls_file')) {

            $file = $request->file('gls_file');

            $cnt = 0;
            if (($handle = fopen($file->getPathName(), "r")) !== FALSE) {
                while (($line = fgetcsv($handle, null, ",")) !== FALSE) {
                    if($cnt != 0) {

                        if(!isset($line[1])){
                            continue;
                        }

                        if ($line[6] == ''){
                            continue;
                        }

                        $deliveryTo = $line[0]; // Name of the person how received the package
                        $dateExpedition = $line[1];
                        $dateLivrasion = $line[2];
                        $orderNum = $line[8];
                        $colisNum = $line[6];
                        $statusLivrasion = $line[14];

                        $dateExpedition = preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/", "$3-$2-$1", $dateExpedition);
                        if ($dateLivrasion != "") 
                            $dateLivrasion = preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/", "$3-$2-$1", $dateLivrasion);

                        //Update order´s tracking number and dates, from the csv file

                        //$order = \App\Models\Orders::where('orderNum', '=' , $orderNum)->first();
                        $order = Orders::where('orderNum', '=' , $orderNum)->first();

                        // Here comes all about data update, it´s big
                        if(Isset($order) > 0){

                            $order->colisNum = $colisNum;
                            
                            $order->dateExpedition = $dateExpedition;
                            if ($dateLivrasion != "")
                                $order->dateLivrasion = $dateLivrasion;

                                
                                
                            //ToDo: This comes form the python, but at it is now, with the 3 states, it´s ok
                            
                            if (strpos($statusLivrasion, "Reception") !== false) {

                                $order->deliveryStatus = 'Send'; //ToDO: Este esta repetido ?

                                $deliveries_send = Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Send')
                                ->first();

                                if(!Isset($deliveries_send)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_send->id);
                                }

                                $entrega->status = 'Send';

                            } else if( strpos($statusLivrasion, "Expedition") !== false  ) {

                                $order->deliveryStatus = 'Send';

                                $deliveries_send = Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Send')
                                ->first();

                                if(!Isset($deliveries_send)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_send->id);
                                }

                                $entrega->status = 'Send';

                            } else if( strpos($statusLivrasion, "Mis en livraison") !== false  ) {

                                $order->deliveryStatus = 'On delivery';

                                $deliveries_send = Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'On delivery')
                                ->first();

                                if(!Isset($deliveries_send)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_send->id);
                                }

                                $entrega->status = 'On delivery';

                            } else if( strpos($statusLivrasion, "Colis livre") !== false  ) {

                                $order->deliveryStatus = 'Delivered';

                                $deliveries_delivered = \App\Models\Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Delivered')
                                ->first();

                                //dd($deliveries_delivered);

                                if(!Isset($deliveries_delivered)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_delivered->id);
                                }

                                $entrega->status = 'Delivered';   

                            //ToDo: All Non deliveried, have different errors but the same at db
                            } else if( strpos($statusLivrasion, "Non livre car reception fermee") !== false  ) {

                                $order->deliveryStatus = 'Non deliveried';

                                $deliveries_cancelled = \App\Models\Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Non deliveried')
                                ->first();

                                if(!Isset($deliveries_cancelled)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_cancelled->id);
                                }

                                $entrega->status = 'Non deliveried';

                            } else if( strpos($statusLivrasion, "Non livre du a un probleme d adresse") !== false  ) {

                                $order->deliveryStatus = 'Non deliveried';

                                $deliveries_cancelled = \App\Models\Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Non deliveried')
                                ->first();

                                if(!Isset($deliveries_cancelled)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_cancelled->id);
                                }

                                $entrega->status = 'Non deliveried';

                            } else if( strpos($statusLivrasion, "Non livre car non presente") !== false  ) {

                                $order->deliveryStatus = 'Non deliveried';

                                $deliveries_cancelled = \App\Models\Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Non deliveried')
                                ->first();

                                if(!Isset($deliveries_cancelled)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_cancelled->id);
                                }

                                $entrega->status = 'Non deliveried';

                            } else if( strpos($statusLivrasion, "Non mis en livraison rendez vous prevu a date fixe") !== false  ) {

                                $order->deliveryStatus = 'Non deliveried';

                                $deliveries_cancelled = \App\Models\Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Non deliveried')
                                ->first();

                                if(!Isset($deliveries_cancelled)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_cancelled->id);
                                }

                                $entrega->status = 'Non deliveried';

                            } else if( strpos($statusLivrasion, "Non mis en livraison car l entreprise est fermee") !== false  ) {

                                $order->deliveryStatus = 'Non deliveried';

                                $deliveries_cancelled = \App\Models\Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Non deliveried')
                                ->first();

                                if(!Isset($deliveries_cancelled)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_cancelled->id);
                                }

                                $entrega->status = 'Non deliveried';

                            } else if( strpos($statusLivrasion, "Enlevement realise complement") !== false  ) {

                                $order->deliveryStatus = 'Cancelled';

                                $deliveries_delivered = \App\Models\Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Cancelled')
                                ->first();

                                if(!Isset($deliveries_delivered)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_delivered->id);
                                }

                                $entrega->status = 'Cancelled';
                                
                            } else if( strpos($statusLivrasion, "Expedition a l ordre du service ramassage") !== false  ) {

                                $order->deliveryStatus = 'Send';

                                $deliveries_send = \App\Models\Delivery::where('colisNum', '=', $colisNum)
                                ->where('status', '=' , 'Send')
                                ->first();

                                if(!Isset($deliveries_send)){
                                    $entrega = new Delivery();
                                } else {
                                    $entrega = Delivery::find($deliveries_send->id);
                                }

                                $entrega->status = 'Send';
                                
                            } else {
                                $text = 'Missing status Livrasion: ' . $statusLivrasion ; 
                                Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
                            }

                            // Entrega es el objeto buscado o nuevo, donde aplicaremos los datos obtenidos
                            // No deberia pasar, pero si no hay pedido muestra asi despues si hay algun pedido que se haya recogido

                            if(Isset($entrega)) {
                                $entrega->orders_id = $order->id;
                                $entrega->orderNum = $orderNum;
                                $entrega->colisNum = $colisNum;
                                $entrega->dateExpedition = $dateExpedition;
                                if ($dateLivrasion != "") 
                                    $entrega->dateLivrasion = $dateLivrasion;
                                
                                $entrega->save();

                                $order->save();
                            }

                            if(isset($entrega)) $return_array[] = $entrega;
                            else $return_array_not_found[] = $orderNum;

                        } else {
                            $return_array_not_found[] = $orderNum;
                        }

                    }
                    $cnt ++;
                    
                }
            }
        }

        //return null;
        
        if (isset($return_array) && isset($return_array_not_found)) {
            
            $entrega = $return_array;
            return view('admin.dataloader.gls', compact('entrega', 'return_array_not_found'));
        } else if (!isset($return_array) && isset($return_array_not_found)){
            //var_dump($return_array_not_found);
            return view('admin.dataloader.gls', compact('return_array_not_found'));
        } else if (isset($return_array) && !isset($return_array_not_found)) {
            $entrega = $return_array;
            return view('admin.dataloader.gls', compact('entrega'));
        } else {
            $no_data = '1';
            return view('admin.dataloader.gls', compact('no_data'));
        }
        //return back()->with('success', 'File uploaded successfully.')
        //->with('entrega', $entrega)
        //->withInput();

    }

    public function proof(){
        
        $orders = Orders::whereNotExists(function($query)
        {
            $query->select(DB::raw(1))
                  ->from('delivery_files')
                  ->whereRaw('delivery_files.orders_id = orders.id');
        })->get();

        $ordersExists = Orders::whereExists(function($query)
        {
            $query->select(DB::raw(1))
                  ->from('delivery_files')
                  ->whereRaw('delivery_files.orders_id = orders.id');
        })->get();
        
        return view('admin.dataloader.proof', compact('orders', 'ordersExists'));

    }

    public function proofUpload(){
        
        $orders = Orders::whereNotExists(function($query)
        {
            $query->select(DB::raw(1))
                  ->from('delivery_files')
                  ->whereRaw('delivery_files.orders_id = orders.id');
        })->get();
        
        return view('admin.dataloader.proofupload', compact('orders'));

    }

    public function proofDelete(){

        //ToDo: Not finished, started with pagination, but i´m redoing GLS

        $ordersExists = Orders::whereExists(function($query)
        {
            $query->select(DB::raw(1))
                  ->from('delivery_files')
                  ->whereRaw('delivery_files.orders_id = orders.id');
        })->paginate(25);
        
        return view('admin.dataloader.proofdelete', compact('ordersExists'));

    }
    public function sendProof(Request $request){

        $request->validate([
            'proof_file' => 'required',
        ]);

        if ($request->hasFile('proof_file')) {
            
            $deliveryFile = DeliveryFiles::where('orders_id', '=', $request->order_id)->get();
            
            if( count($deliveryFile) ){
                $file = DeliveryFiles::find($deliveryFile->id);
            } else {
                $file = new DeliveryFiles();
            }

            $file->orders_id = $request->order_id;
            $file->fileName = $request->proof_file->getClientOriginalName();

            $file->save();

            $request->proof_file->storeAs('proof_uploads/' . $request->order_id .'/' . $file->id . "/", $request->proof_file->getClientOriginalName(), 'public');

        }

        return back()->with('success', 'File uploaded successfully.');
        
    }

    public function deleteProofFile (Request $request, int $id) {

        $fileDB = DeliveryFiles::find($id);
        
        $directory = App::basePath() . "\\storage\\app\\public\\proof_uploads\\" . $fileDB->orders_id . "\\" . $fileDB->id . "\\";

        $filePath = $directory . $fileDB->fileName;

        unlink($filePath);
        rmdir($directory);
        
        $file = DeliveryFiles::find($id)->delete();

        return back()->with('success', 'File deleted successfully.');

    }

}
