<?php

namespace App\Http\Controllers;

use Carbon\Carbon;;
use App\Mail\InfoMail;
use App\Models\Orders;

use GuzzleHttp\Client;
use App\Helpers\GlsHelper;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\RequestException;

class TestController extends Controller
{

    public function endOfDay (){

        $date = Carbon::now()->format('Y-m-d');

        $client = new Client(['auth' => [env('GLS_USERNAME'), env('GLS_PASSWORD')]]);

        $response = $client->request(
                                'POST',
                                env('GLS_URL_END_OF_DAY_URL'),
                                [
                                    'debug' => false,
                                    'verify' => false,
                                    //'query' => [ 'DateFrom' => $from, 'DateTo' => $to ],
                                    'query' => [ 'date' => $date ],
                                    'headers' => [
                                                    'Accept' => 'application/glsVersion1+json, application/json',
                                                    'Content-Type' => 'application/glsVersion1+json'
                                    ],
                                    //'form_params' => ['param1' => 'value1']
                                ]
                            );

        $statusCode = $response->getStatusCode();
        $response_decoded = json_decode($response->getBody());

        SearchHelper::DebuggerVar('StatusCode', $statusCode);
        echo('<pre>');

        //var_dump($response_decoded);
        $params['headers'] = [
            'Accept' => 'application/glsVersion1+json, application/json',
            'Content-Type' => 'application/glsVersion1+json'
        ];

        $params['verify'] = false;

        if ( isset( $response_decoded->Shipments ) ){
            foreach($response_decoded->Shipments as $track){
                //var_dump($track->ShipmentUnit);

                if (isset($track->ShipmentUnit[0]->TrackID)){
                    SearchHelper::DebuggerTxT('TrackID: ' . $track->ShipmentUnit[0]->TrackID);

                    $params['body'] = '{
                        "TrackID" : "' . $track->ShipmentUnit[0]->TrackID . '"
                        }';

                    try {

                        $response_track = $client->post(env('GLS_URL_POD'), $params);

                        $response_var = json_decode($response_track->getBody());

                        /*
                            {
                                "PODItem": {
                                    "TrackID": "P3L11002",
                                    "ImageData": "JVBERi0xLjQKJfbk/N8...kKJSVFT0YK"
                                }
                            }
                        */

                        echo('<pre>');
                        SearchHelper::DebuggerTxT("Founded POD");
                        var_dump($response_var->ImageData);
                        echo('</pre>');

                    }
                    catch (RequestException  $e) {

                        $response = $e->getResponse();
                        var_dump($response->getStatusCode()); // HTTP status code;
                        var_dump($response->getReasonPhrase()); // Response message;
                        var_dump($response->getHeader('message')['0']); // Concrete header value;
                    }

                } else {
                    SearchHelper::DebuggerTxT('Not found trackID');
                }

            }
        }

        echo('</pre>');

    }


    public function getParcels(){

        $from = '2023-07-11';
        $to = '2023-07-11';

        $client = new Client(['auth' => [env('GLS_USERNAME'), env('GLS_PASSWORD')]]);

        $params['headers'] = [
            'Accept' => 'application/glsVersion1+json, application/json',
            'Content-Type' => 'application/glsVersion1+json'
        ];

        $params['verify'] = false;

        $params['body'] = '{
                    "DateFrom": "' . $from . '",
                    "DateTo": "' . $to . '"
                }';

        $response = $client->post(env('GLS_URL_PARCELS'), $params);

        $response_var = json_decode($response->getBody());
        echo('<pre>');
        var_dump($response_var);
        echo('</pre>');

        $cnt = 0;

        /*
        {
            "UnitItems": [{
                    "TrackID": "P3L11002",
                    "ShipmentReference": "abdeckjdefsss012",
                    "ShipmentUnitReference": "RefTwo",
                    "InitialDate": "2016-02-07T13:17:15+01:00",
                    "Status": "DELIVERED"
                }
            ]
        }
        */
        //return null;
        if(isset($response_var->UnitItems)){
            foreach($response_var->UnitItems as $tracking) {
                SearchHelper::DebuggerTxT('TrackID: ' . $tracking->TrackID);

                //ToDo: Esto es por si hay suerte y coincide con lo que viene en el pdf
                $order = Orders::where('OrderNum', '=', $tracking->ShipmentReference)->get();

                if (count($order)){
                    $created = GlsHelper::getPODandStoreIT($tracking->TrackID, $order[0]->id);
                    if ( ! $created ) {
                        //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('No POD for TrackID: '  . $tracking->TrackID));
                    }
                } else {
                    Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('No order for ShipmentReference: '  . $tracking->ShipmentReference));
                }

            }
        } else {
            SearchHelper::DebuggerTxT('Not found');
        }

    }


    public function test(){

        $from = '2023-07-11';
        $to = '2023-07-10';

        $date = Carbon::now()->format('Y-m-d');

        /*
            You can use the following TrackID

            00HRV59J
            00HRV5AB

        */

        $client = new Client(['auth' => [env('GLS_USERNAME'), env('GLS_PASSWORD')]]);

        $response = $client->request(
                                'POST',
                                env('GLS_URL_END_OF_DAY_URL'),
                                [
                                    'debug' => false,
                                    'verify' => false,
                                    //'query' => [ 'DateFrom' => $from, 'DateTo' => $to ],
                                    'query' => [ 'date' => $from ],
                                    'headers' => [
                                                    'Accept' => 'application/glsVersion1+json, application/json',
                                                    'Content-Type' => 'application/glsVersion1+json'
                                    ],
                                    //'form_params' => ['param1' => 'value1']
                                ]
                            );

        $statusCode = $response->getStatusCode();
        $response_decoded = json_decode($response->getBody());

        SearchHelper::DebuggerVar('StatusCode', $statusCode);
        echo('<pre>');
        var_dump($response_decoded);
        echo('</pre>');

        if ( isset( $response_decoded->Shipments ) ){
            foreach($response_decoded->Shipments as $track){
                SearchHelper::DebuggerTxT('TrackID: ' . $track->ShipmentUnit->TrackID);
            }
        }

        //return null;

        $params['headers'] = [
                                'Accept' => 'application/glsVersion1+json, application/json',
                                'Content-Type' => 'application/glsVersion1+json'
                            ];

        $params['verify'] = false;

        //$params['form_params'] = [ 'DateFrom' => $from, 'DateTo' => $to ];
        //$params['query'] = [ 'date' => $from  ];

        //$params['query'] = [ 'DateFrom' => $from, 'DateTo' => $to ];
        $params['body'] = '{
                                "DateFrom": "2023-07-07",
                                "DateTo": "2023-07-07"
                            }';

        $response = $client->post(env('GLS_URL_PARCELS'), $params);

        //SearchHelper::DebuggerVar('StatusCode 2', $response->getStatusCode());

        $response_var = json_decode($response->getBody());
        //echo('<pre>');
        //var_dump($response_var);
        //echo('</pre>');

        $cnt = 0;

        //return null;
        if(isset($response_var->UnitItems)){
            foreach($response_var->UnitItems as $tracking) {
                SearchHelper::DebuggerTxT('Track: ' . $tracking->TrackID);

                if(isset($tracking->ShipmentReference)) {
                    SearchHelper::DebuggerTxT('ShipmentReference: ' . $tracking->ShipmentReference[0]);
                }

                SearchHelper::DebuggerTxT('Status: ' . $tracking->Status);

                $params['body'] = '{
                                    "TrackID" : "' . $tracking->TrackID . '"
                                    }';

                try {

                    $response_track = $client->post(env('GLS_URL_TRACKING_DETAILS'), $params);

                    $response_var = json_decode($response_track->getBody());

                    echo('<pre>');
                    //var_dump($response_var->UnitDetail->History);
                    //var_dump($response_var->UnitDetail->TrackID);
                    var_dump($response_var->UnitDetail);
                    echo('</pre>');

                    foreach($response_var->UnitDetail->History as $history){
                        //SearchHelper::DebuggerTxT('History Status: ' . $history->StatusCode);
                    }

                }
                catch (RequestException  $e) {

                    $response = $e->getResponse();
                    //var_dump($response->getStatusCode()); // HTTP status code;
                    var_dump($response->getReasonPhrase()); // Response message;
                    //var_dump((string) $response->getBody()); // Body, normally it is JSON;
                    //var_dump(json_decode((string) $response->getBody())); // Body as the decoded JSON;
                    //var_dump($response->getHeaders()); // Headers array;
                    //var_dump($response->hasHeader('Content-Type')); // Is the header presented?
                    //var_dump($response->getHeader('message')['0']); // Concrete header value;

                    //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('TrackID Not Found: ' . $tracking->TrackID . ' - Error: ' . $response->getHeader('message')['0']));
                }

                $params['body'] = '{
                    "TrackID" : "' . $tracking->TrackID . '"
                    }';

                try {

                    $response_track = $client->post(env('GLS_URL_POD'), $params);

                    $response_var = json_decode($response_track->getBody());

                    echo('<pre>');
                    SearchHelper::DebuggerTxT("Founded POD");
                    var_dump($response_var);
                    echo('</pre>');

                }
                catch (RequestException  $e) {

                    $response = $e->getResponse();
                    //var_dump($response->getStatusCode()); // HTTP status code;
                    var_dump($response->getReasonPhrase()); // Response message;
                    //var_dump((string) $response->getBody()); // Body, normally it is JSON;
                    //var_dump(json_decode((string) $response->getBody())); // Body as the decoded JSON;
                    //var_dump($response->getHeaders()); // Headers array;
                    //var_dump($response->hasHeader('Content-Type')); // Is the header presented?
                    var_dump($response->getHeader('message')['0']); // Concrete header value;
                    var_dump($response->getHeader('error')['0']); // Concrete header value;

                    //Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('Proof of Delivery Not Found: ' . $tracking->TrackID . ' - Error: ' . $response->getHeader('message')['0']));
                }


                $cnt ++ ;

                //DeV: Para que no haga muchos
                if ($cnt >= 10)
                    break;
            }




        } else {
            echo('<pre>');
            var_dump($response_var);
            echo('</pre>');
        }

    }

    public function buscarCadenaEnObjeto($objeto, $cadena) {
        foreach ($objeto as $clave => $valor) {

            echo("<pre>");
            echo("JuJú");
            var_dump($objeto);
            echo("</pre>");

            if (is_object($valor)) {
                $this->buscarCadenaEnObjeto($valor, $cadena);
            } else if (is_string($valor) && strpos($valor, $cadena) !== false) {
                return true;
            }
        }
        return false;
    }

}
