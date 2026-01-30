<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Delivery;
use App\Models\RecordingSearch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SearchHelper {

    public static function getDataForRecovery ($line){
        $return = array();
        try {
            $return['date_operation'] = Carbon::createFromFormat('j/n/Y', $line[2]);
        } catch (\Exception $e) {
            $return['date_operation'] = Carbon::now()->format('Y-m-d');
        }
        preg_match('/FA\d+/', $line[5], $coincidencias);
        if (!empty($coincidencias)) {
            $return['invoice'] = $coincidencias[0];
        } else {
            $return['invoice'] = 'NONE';
        }
        if (str_contains($line[5], 'TIRAGE CONTESTE')) {
            $return['libelle_rejet'] = 'TIRAGE CONTESTE';
        } else if (preg_match('/FA\d+-(.+)/', $line[5], $coincidencias_2)) {
            $codigo = $coincidencias_2[1];
            $return['libelle_rejet'] = trim($codigo);
        } else {
            $return['libelle_rejet'] = '';
        }
        return $return;
    }

    public static function indexRecordings ($opr, $conn_id){
        $cnt = 0;
        //dump($opr);
        $temp_opr = str_replace('RECORDS/V5/', '', $opr);
        $years = Storage::disk('ftp_hermes')->directories($opr);
        foreach($years as $year){
            $temp_year = str_replace($opr . '/', '', $year);
            //if ($temp_year == '2023'){
            if ($temp_year == date('Y')){
                //dump($year);
                //dump(date('Y'));
                $months = Storage::disk('ftp_hermes')->directories($year);
                foreach($months as $month){
                    $temp_month = str_replace($year . '/', '', $month);
                    //dump($temp_month);
                    //if ($temp_month >= '01' && $temp_month <= '03'){
                    //if ($temp_month >= '04' && $temp_month <= '06'){
                    //if ($temp_month >= '07' && $temp_month <= '09'){
                    //if ($temp_month >= '10' && $temp_month <= '12'){
                    //if ($temp_month == '01'){
                    if ($temp_month == date('m')){
                        //dump($month);
                        //dump('Entra en 07');
                        //foreach($months as $month){ // Wrong
                        $days = Storage::disk('ftp_hermes')->directories($month);
                        foreach($days as $day){
                            //dump($day);
                            $temp_day = str_replace($month . '/', '', $day);
                            $days_done = '2023 - 04 // 06';
                            //if ($temp_day >= '01' && $temp_day <= '10') {
                            //if ($temp_day >= '11' && $temp_day <= '20') {
                            //if ($temp_day >= '21' && $temp_day <= '31') {
                            if ($temp_day == date('d')) {
                                $operators = Storage::disk('ftp_hermes')->directories($day);
                                foreach($operators as $operator){
                                    //dump($operator);
                                    $temp_operator = str_replace($day . '/', '', $operator);
                                    $recordings = Storage::disk('ftp_hermes')->files($operator);
                                    foreach($recordings as $record){
                                        //dump($record);
                                        $temp_record = str_replace($operator . '/', '', $record);

                                        $elFinal = substr($record, strrpos($record, '#') + 1);
                                        //dump($elFinal);
                                        $cip = str_replace('.wav', '', $elFinal);
                                        //dump($cip);
//dump($temp_opr . ' - ' . $temp_year . '/' . $temp_month . '/' . $temp_day . ' - ' . $temp_operator . ' - ' . $temp_record . ' - ' . $cip );
                                        //dump($record);

                                        $buff = ftp_mdtm($conn_id, $record);

                                        if ($buff != -1) {
                                            // somefile.txt was last modified on: March 26 2003 14:16:41.
                                            //echo "$temp_record was last modified on : " . date(app('global_format_datetime'), $buff);
                                        } else {
                                            echo "Couldn't get mdtime";
                                        }

                                        $exists = RecordingSearch::where('filename', '=', $temp_record)->get();
                                        
                                        if( ! isset($exists[0]->id)){
                                            $db_insert = New RecordingSearch();
                                            $db_insert->operation = $temp_opr;
                                            $db_insert->operator = $temp_operator;
                                            $db_insert->filename = $temp_record;
                                            $db_insert->path = '/' . $record;
                                            $db_insert->cip = $cip;
                                            $db_insert->datetime = date(app('global_format_datetime'), $buff);
                                            $db_insert->date = date(app('global_format_date'), $buff);
                                            $db_insert->time = date('H:i', $buff);
                                            //$db_insert->time = date('H:i:s', $buff);

                                            $db_insert->save();
                                            //dump('Inserted');
                                            $cnt++;
                                        } else {
                                            //dump('Not inserted');
                                        }
                                    }
                                }
                            } // Days
                        }
                        //} // Wromg
                    } // Month
                }
            } // Year
        }

        return $cnt;
    }

    public static function getInvoiceDB ($order){

        //$order->OrderNum = '1299700';

        $sageOrder = DB::connection('sqlsrv_sage')
            ->table('C_BN_SANTE.dbo.F_DOCENTETE')
            ->select("Do_Piece as invoice", "DO_Date as date")
            ->where('DO_Ref', '=', $order->OrderNum)
            ->where('DO_Piece', 'like', 'FA%')
            ->where('do_type', '=', '7')
            ->get();

        $cmcOrder = DB::connection('sqlsrv_sage')
            ->table('C_CMC.dbo.F_DOCENTETE')
            ->select("Do_Piece as invoice", "DO_Date as date")
            ->where('DO_Ref', '=', $order->OrderNum)
            ->where('DO_Piece', 'like', 'FA%')
            ->where('do_type', '=', '7')
            ->get();

        if ( count($sageOrder) ){
            $invoices = $sageOrder;
        } else if ( count($cmcOrder) ){
            $invoices = $cmcOrder;
        } else {
            $invoices = false;
        }

        return $invoices;
    }

    public static function getInvoiceType ($order){

        //$order->OrderNum = '1299700';

        $sageOrder = DB::connection('sqlsrv_sage')
            ->table('C_BN_SANTE.dbo.F_DOCENTETE')
            ->select("Do_Piece as invoice")
            ->where('DO_Ref', '=', $order->OrderNum)
            ->where('DO_Piece', 'like', 'FA%')
            ->where('do_type', '=', '7')
            ->get();

        $cmcOrder = DB::connection('sqlsrv_sage')
            ->table('C_CMC.dbo.F_DOCENTETE')
            ->select("Do_Piece as invoice")
            ->where('DO_Ref', '=', $order->OrderNum)
            ->where('DO_Piece', 'like', 'FA%')
            ->where('do_type', '=', '7')
            ->get();

        if ( count($sageOrder) ){
            $type = 'sage';
        } else if ( count($cmcOrder) ){
            $type = 'cmc';
        } else {
            $type = 'none';
        }

        return $type;
    }

    public static function getSearchType ($searchText) {

    }

    public static function getDelivery($colisNum, $itemId, $status, $item) {

        $item->deliveryStatus = $status;

        $deliveries_send = Delivery::where('colisNum', $colisNum)
                                    ->where('order_items_id', $itemId)
                                    ->where('status', $status)
                                    ->first();
    
        if (!isset($deliveries_send)) {
            $entrega = new Delivery();
        } else {
            $entrega = Delivery::find($deliveries_send->id);
        }

        $entrega->status = $status;
    
        return $entrega;
    }

    public static function bindBuilderQuery($sqlArr){
        
        foreach($sqlArr as $key => $value) {
            $sqlTxt = str_replace('?', '%s', $value["query"]);
            $sqlTxt = sprintf($sqlTxt, ...$value["bindings"]);
            $num = $key + 1;
            //print_r($sqlTxt);
            //if (env('LOG_DEBUG')) 
                SearchHelper::DebuggerTxT("$num - $sqlTxt");
        }
    }

    public static function convertirFechaParaSAGE($fecha) {

        if (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $fecha, $matches)) {
          $anio = $matches[1];
          $mes = $matches[2];
          $dia = $matches[3];
          
          return $dia . '-' . $mes . '-' . $anio;
        }
        
        return false; // Devuelve false si la fecha no tiene el formato esperado
    }

    public static function getSageOrdersFromStatus($status, $from, $to){

        return DB::connection('sqlsrv_sage')
                    ->table('C_BN_SANTE.dbo.F_DOCENTETE')
                    ->select("DO_Ref as reference")
                    ->whereBetween('DO_Date', [$from, $to])
                    ->where('DO_Type', '=', $status)
                    ->get();

    }
    
    public static function getCMCOrdersFromStatus($status, $from, $to){

        return DB::connection('sqlsrv_sage')
                    ->table('C_CMC.dbo.F_DOCENTETE')
                    ->select("DO_Ref as reference")
                    ->whereBetween('DO_Date', [$from, $to])
                    ->where('DO_Type', '=', $status)
                    ->get();

    }

    public static function DebuggerVar ($msg, $var){
        echo("<HR>");
        echo($msg);
        echo("<HR>");
        var_dump($var);
        echo("<HR>");
        //Log::debug($msg);
        //Log::debug($var);
    }

    public static function DebuggerArr ($msg, $var){
        echo("<HR>");
        echo($msg);
        echo("<HR>");
        print_r($var);
        echo("<HR>");
        //Log::debug($msg);
        //Log::debug($var);
    }

    public static function DebuggerTxT ($msg){
        echo("<HR>");
        echo($msg);
        echo("<HR>");
        //Log::debug($msg);
    }

    public static function UsersActions (){
        if(Auth::check()){ 
            $backtrace = debug_backtrace();
            Log::debug(Auth::user()->name . ' accesed: ' .  str_replace('App\\Http\\Controllers\\', '', $backtrace[1]['class']) . ' - Function: ' . $backtrace[1]['function'] );
        }
    }

    public static function arrayToCSV($array, $filename) {
        $file = fopen($filename, 'w');

        foreach ($array as $row) {
            fputcsv($file, $row,";");
        }
    
        fclose($file);
    }

    public static function getURLStatus($url) {
        // Realizar la llamada a la URL y obtener el contenido
        $content = @file_get_contents($url);
    
        // Obtener los encabezados de la respuesta HTTP
        $headers = @get_headers($url);
    
        // Verificar si se obtuvo el contenido y los encabezados
        if ($content && $headers) {
            // Obtener el estado de la llamada HTTP
            $status = explode(" ", $headers[0])[1];
    
            return $status;
        } else {
            // Retornar un estado de error si no se pudo realizar la llamada
            return "Error";
        }
    }
    
  
}