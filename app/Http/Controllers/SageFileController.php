<?php

namespace App\Http\Controllers;

use DateTime;
use stdClass;
use Carbon\Carbon;
use App\Mail\InfoMail;
use App\Mail\ReportMail;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SageFileController extends Controller
{
    public function ecommerceSage(){

        SearchHelper::UsersActions();

        return view('filegenerator.ecommercesage');

    }

    public function generateSageFileFromEcommerceCron (){

        SearchHelper::UsersActions();

        $directoryApp = App::basePath() . "\\storage\\app\\public\\generated_Files\\";
        if (!file_exists($directoryApp)) mkdir($directoryApp);
        $directoryEcommerceSage = App::basePath() . "\\storage\\app\\public\\generated_Files\\ecommerce_sage\\";
        if (!file_exists($directoryEcommerceSage)) mkdir($directoryEcommerceSage);

        //$from = Carbon::today()->subDays(2)->format(app('global_format_date')) . " 00:00:00";
        $from = Carbon::today()->format(app('global_format_date')) . " 00:00:00";
        $to   = date(app('global_format_date').' 23:59:59');

        $sql="
                    SELECT
                    F.cip as CIP,
                    LTRIM(RTRIM(CONVERT(char(10),O.created_at, 103))) as DATE_COMM,
                    O.reference as NUM_COM,
                    P.VAT as TVA,
                    P.ean as CD_ART,
                    CASE
                        WHEN D.discount = 100 THEN D.quantity
                        ELSE null
                    END as ECH_ART,
                    D.price as PHT_U,
                    D.quantity as QTE_ART,
                    D.discount as REM,
                    O.desired_delivery_date as DATE_LIVR,
                    'Biogyne' as OPERATION,
                    --L.name as OPERATION,
                    O.comments as COMMENTAIRE,
                    O.tele_operator_id as NUM_TA,
                    OP.first_name as NOM_TA,
                    OP.last_name as PRENOM_TA,
                    'Biogyne' as LABORATOIRE
                    --L.name as LABORATOIRE

                    FROM [ECOMMERCE].[dbo].[order] as O
                    join [ECOMMERCE].[dbo].[order_detail] as D on O.id = D.order_id
                    join [ECOMMERCE].[dbo].[product] as P on D.product_id = P.id
                    join [ECOMMERCE].[dbo].pharmacy as F on O.pharmacy_id = F.id
                    join [ECOMMERCE].[dbo].laboratory as L on P.laboratory_id = L.id
                    join [ECOMMERCE].dbo.tele_operator as OP on O.tele_operator_id = OP.id

                    where o.updated_at BETWEEN CONVERT(datetime, '".$from."') AND CONVERT(datetime, '".$to."')
                    and o.status = 'confirmed'

        ";

        //echo($sql);

        $orders = DB::connection('sqlsrv')->select($sql);

        $arr[] = array('CIP', 'DATE_COMM', 'NUM_COM', 'TVA', 'CD_ART', 'ECH_ART', 'PHT_U', 'QTE_ART', 'REM', 'DATE_LIVR'
        , 'OPERATION', 'COMMENTAIRE', 'NUM_TA', 'NOM_TA', 'PRENOM_TA', 'LABORATOIRE');

        $orders=array_map(function($item){
            return (array) $item;
        },$orders);

        // Al array que ya he inicializado con las cabeceras, le añado todo lo otro
        foreach( $orders as $record ){

            $pattern = '/(\d{2})\/(\d{2})\/(\d{4})/';
            $replacement = '$3-$2-$1';

            $record['DATE_LIVR'] = preg_replace($pattern, $replacement, $record['DATE_LIVR']);

            //$record['REM'] = number_format($record['REM'],2);
            if($record['REM'] == '.00')
                $record['REM'] = '0';

            $record['REM'] = $record['REM'] / 100;

            //if ($record['COMMENTAIRE'] == '')
                //$record['COMMENTAIRE'] = '\" \"';

            $arr[] = $record;
        }

        $date = new DateTime();

        $fileName = $date->format("Ymd_His");

        //$sagePath = "\\\\172.20.90.49\\wwwroot\\none\\ORDERS\\PRODUCTS_EXPORTS\\BNSANTE\\SAGE\\IN\\";
        //$file = $directoryEcommerceSage . "SALES_ORDERS_BNSANTE_" . $fileName . '.csv';
        $file = env('SAGE_FILE_PATH') . "SALES_ORDERS_BNSANTE_" . $fileName . '.csv';

        SearchHelper::arrayToCSV($arr, $file);

        $mailInfo["txt"] = "Lines generated: " . ( count($arr) -1 );

        Mail::to(env('EMAIL_FOR_REPORTS'))->send(new ReportMail($mailInfo, $file, "SALES_ORDERS_BNSANTE_" . $fileName . '.csv'));

        // El insert para Order Controller

        /*

        $url=env('URL_ORDER_CONTROLLER_SAGE') . "SALES_ORDERS_BNSANTE_" . $fileName . '.csv';

        $response = Http::get($url);
        $status = $response->status();

        if ( ! $status == '200') {
            $text = 'Error: ' . $response->status() . ' with URL: ' . $url ;
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }

        */

        SearchHelper::DebuggerTxT('Sage file generated: ' . $file);

        //return response()->download($file);
    }

    public function generateSageFileFromEcommerce(){

        $directoryApp = App::basePath() . "\\storage\\app\\public\\generated_Files\\";
        if (!file_exists($directoryApp)) mkdir($directoryApp);
        $directoryEcommerceSage = App::basePath() . "\\storage\\app\\public\\generated_Files\\ecommerce_sage\\";
        if (!file_exists($directoryEcommerceSage)) mkdir($directoryEcommerceSage);

        $date = new DateTime();
        $date->format("Y-d-m");

        $from = Carbon::today()->subMonth()->toDateString() . " 00:00:00";
        $from = Carbon::today()->subDays(env('GET_ORDERS_FROM_DAYS'))->toDateString() . " 00:00:00";

        $from = Carbon::today()->format("Y-d-m") . " 00:00:00";
        $to = Carbon::today()->format("Y-d-m") . " 23:59:59";

        $from = date(app('global_format_date').' 00:00:00');

        $from = Carbon::today()->subDays(2)->format(app('global_format_date')) . " 00:00:00";
        //$from = Carbon::today()->subDays(2)->toDateString() . " 00:00:00";

        $to   = date(app('global_format_date').' 23:59:59');
        //$to = Carbon::today()->toDateString() . " 23:59:59";


        $sql="
                    SELECT
                    F.cip as CIP,
                    LTRIM(RTRIM(CONVERT(char(10),O.created_at, 103))) as DATE_COMM,
                    O.reference as NUM_COM,
                    P.VAT as TVA,
                    P.ean as CD_ART,
                    CASE
                        WHEN D.discount = 100 THEN D.quantity
                        ELSE null
                    END as ECH_ART,
                    D.price as PHT_U,
                    D.quantity as QTE_ART,
                    D.discount as REM,
                    O.desired_delivery_date as DATE_LIVR,
                    'Biogyne' as OPERATION,
                    --L.name as OPERATION,
                    O.comments as COMMENTAIRE,
                    O.tele_operator_id as NUM_TA,
                    OP.first_name as NOM_TA,
                    OP.last_name as PRENOM_TA,
                    'Biogyne' as LABORATOIRE
                    --L.name as LABORATOIRE

                    FROM [ECOMMERCE].[dbo].[order] as O
                    join [ECOMMERCE].[dbo].[order_detail] as D on O.id = D.order_id
                    join [ECOMMERCE].[dbo].[product] as P on D.product_id = P.id
                    join [ECOMMERCE].[dbo].pharmacy as F on O.pharmacy_id = F.id
                    join [ECOMMERCE].[dbo].laboratory as L on P.laboratory_id = L.id
                    join [ECOMMERCE].dbo.tele_operator as OP on O.tele_operator_id = OP.id

                    --where o.updated_at BETWEEN CONVERT(datetime, '".$from."') AND CONVERT(datetime, '".$to."')
                    where o.updated_at BETWEEN CONVERT(date, '20241018') AND CONVERT(date, '20241020')
                    and o.status = 'confirmed'
                    AND O.laboratory_name = 'BIOGYNE'
        ";

        //echo($sql);

        $orders = DB::connection('sqlsrv')->select($sql);

        //dd($orders);

        $arr[] = array('CIP', 'DATE_COMM', 'NUM_COM', 'TVA', 'CD_ART', 'ECH_ART', 'PHT_U', 'QTE_ART', 'REM', 'DATE_LIVR'
        , 'OPERATION', 'COMMENTAIRE', 'NUM_TA', 'NOM_TA', 'PRENOM_TA', 'LABORATOIRE');

        $orders=array_map(function($item){
            return (array) $item;
        },$orders);



        // Al array que ya he inicializado con las cabeceras, le añado todo lo otro
        foreach( $orders as $record ){

            $pattern = '/(\d{2})\/(\d{2})\/(\d{4})/';
            $replacement = '$3-$2-$1';

            $record['DATE_LIVR'] = preg_replace($pattern, $replacement, $record['DATE_LIVR']);

            //$record['REM'] = number_format($record['REM'],2);
            if($record['REM'] == '.00')
                $record['REM'] = '0';

            $record['REM'] = $record['REM'] / 100;

            //if ($record['COMMENTAIRE'] == '')
                //$record['COMMENTAIRE'] = '\" \"';

            $arr[] = $record;
        }

        //dd($arr);

        $date = new DateTime();

        $fileName = $date->format("Ymd_His");

        //$sagePath = "\\\\172.20.90.49\\wwwroot\\none\\ORDERS\\PRODUCTS_EXPORTS\\BNSANTE\\SAGE\\IN\\";
        //$file = $directoryEcommerceSage . "SALES_ORDERS_BNSANTE_" . $fileName . '.csv';
        $file = env('SAGE_FILE_PATH') . "SALES_ORDERS_BNSANTE_" . $fileName . '.csv';

        SearchHelper::arrayToCSV($arr, $file);

        $mailInfo["txt"] = "Lines generated: " . ( count($arr) -1 );

        Mail::to(env('EMAIL_FOR_REPORTS'))->send(new ReportMail($mailInfo, $file, "SALES_ORDERS_BNSANTE_" . $fileName . '.csv'));

        // El insert para Order Controller

        /*

        $url=env('URL_ORDER_CONTROLLER_SAGE') . "SALES_ORDERS_BNSANTE_" . $fileName . '.csv';

        $response = Http::get($url);
        $status = $response->status();

        if (!$status == '200') {
            $text = 'Error: ' . $response->status() . ' with URL: ' . $url ;
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }

        */

        return response()->download($file);
    }
}
