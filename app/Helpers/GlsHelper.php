<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use App\Models\DeliveryFiles;
use Illuminate\Support\Facades\App;
use GuzzleHttp\Exception\RequestException;

class GlsHelper {

    public static function getPODandStoreIT ($trackID, $orderID) {

        $client = new Client(['auth' => [env('GLS_USERNAME'), env('GLS_PASSWORD')]]);

        $params['headers'] = [
            'Accept' => 'application/glsVersion1+json, application/json',
            'Content-Type' => 'application/glsVersion1+json'
        ];

        $params['verify'] = false;

        $params['body'] = '{
            "TrackID" : "' . $trackID . '"
            }';

        try {

            $response_track = $client->post(env('GLS_URL_POD'), $params); 

            $response_var = json_decode($response_track->getBody());

            $deliveryFile = DeliveryFiles::where('orders_id', '=', $orderID)->get();
            
            if( count($deliveryFile) ){
                $file = DeliveryFiles::find($deliveryFile->id);
            } else {
                $file = new DeliveryFiles();
            }

            $file->orders_id = $orderID;
            $file->fileName = $trackID . '.pdf';

            $file->save();

            echo('<pre>');
            SearchHelper::DebuggerTxT("Founded POD");
            //var_dump($response_var->ImageData);

            $destination = App::basePath() . '\\storage\\app\\public\\proof_uploads\\' . $orderID .'/' . $file->id . "/" . $file->fileName ;

            $ifp = fopen( $destination, 'wb' ); 

            //ToDo: O Uno
            $data = explode( ',', $response_var->ImageData );
            fwrite( $ifp, base64_decode( $data[ 1 ] ) );
            //ToDo: O otro
            fwrite($ifp, base64_decode($response_var->ImageData));

            fclose( $ifp ); 

        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            var_dump($response->getStatusCode()); // HTTP status code;
            var_dump($response->getReasonPhrase()); // Response message;
            var_dump($response->getHeader('message')['0']); // Concrete header value;
            return false;
        }

        return true;
    }
}