<?php

namespace App\Http\Controllers;

use DateTime;
use App\Mail\InfoMail;
use App\Models\Recordings;
use App\Models\RecordingSearch;
use App\Models\TicketFile;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use App\Helpers\TicketHelper;
use App\Models\DeliveryFiles;
use App\Models\Document;
use App\Models\Orders;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function getDownloadDocument(Request $request, int $id)
    {
        SearchHelper::UsersActions();
        $fileDB = Document::find($id);

        if ($fileDB != null){
            $filePath = App::basePath() . "\\storage\\app\\public\\document_uploads\\" . $fileDB->id . "\\" . $fileDB->fileName;  

            if (file_exists($filePath))
                return response()->download($filePath);
            else {
                $text = 'Missing file for Document: ' . $fileDB->name . ' - id:' . $fileDB->id ; 
                SearchHelper::DebuggerTxT($text);
                Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
            }
        } else {
            $text = 'Missing db record for Document with id: ' . $id; 
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }
    }

    public function getDownloadInvoice(Request $request, int $id, string $name, string $type)
    {
        SearchHelper::UsersActions();
        $order = Orders::find($id);

        if ($type == 'sage') {
            $filePath = env('PATH_FOR_SAGE_INVOICES') . 'V-FA-' .  $name . '.pdf';
        } else if ($type == 'cmc'){
            $filePath = env('PATH_FOR_CMC_INVOICES') . 'V-FA-' .  $name . '.pdf';
        }

        if ( file_exists($filePath) ) {
            return response()->download($filePath);
        } else {
            $text = 'Missing Invoice: ' . $name . ' for Order: ' . $order->OrderNum ; 
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }
    }

    public function getDownloadTicket(Request $request, int $id)
    {
        SearchHelper::UsersActions();
        $fileDB = TicketFile::find($id);

        if ($fileDB != null){
            $file = App::basePath() . "\\storage\\app\\public\\ticket_uploads\\" . $fileDB->tickets_id . "\\" . $fileDB->id . "\\";  

            $filePath = $file . $fileDB->name;

            if (file_exists($filePath))
                return response()->download($filePath);
            else {
                $text = 'Missing file for Ticket: ' . $fileDB->fileName ; 
                SearchHelper::DebuggerTxT($text);
                Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
            }
        } else {
            $text = 'Missing db record for Ticket with id: ' . $id; 
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }
    }
/*
    public function getFileTicket(Request $request, int $id)
    {
        $fileDB = TicketFile::find($id);

        $file = App::basePath() . "\\storage\\app\\public\\ticket_uploads\\" . $fileDB->tickets_id . "\\" . $fileDB->id . "\\";

        $filePath = $file . $fileDB->name; 
        
        if (file_exists($filePath))
            return response()->file($filePath);
        else{
            $text = 'Missing file from Ticket: ' . $fileDB->fileName ; 
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }
    }
*/
    public function getDownloadProof(Request $request, int $id)
    {
        SearchHelper::UsersActions();
        $fileDB = DeliveryFiles::find($id);

        $file = App::basePath() . "\\storage\\app\\public\\proof_uploads\\" . $fileDB->orders_id . "\\" . $fileDB->id . "\\";  

        $filePath = $file . $fileDB->fileName;

        if (file_exists($filePath))
            return response()->download($filePath);
        else{
            $text = 'Missing file from Proof: ' . $fileDB->fileName ; 
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }   
    }

    public function getFileProof(Request $request, int $id)
    {
        SearchHelper::UsersActions();
        $fileDB = DeliveryFiles::find($id);

        $file = App::basePath() . "\\storage\\app\\public\\proof_uploads\\" . $fileDB->orders_id . "\\" . $fileDB->id . "\\";

        $filePath = $file . $fileDB->fileName; 
        
        if (file_exists($filePath))
            return response()->file($filePath);
        else{
            $text = 'Missing file from Proof: ' . $fileDB->fileName ; 
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }
    }

    public function getDownloadRecording(Request $request, int $id)
    {
        SearchHelper::UsersActions();
        $fileDB = Recordings::find($id);

        if (TicketHelper::checkServer(env('HERMES_FTP_HOST'))){

            if(Storage::disk('ftp_hermes')->exists($fileDB->nasPath)){
                ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));
                
                $recording = Storage::disk('ftp_hermes')->get($fileDB->nasPath);
                
                $date = new DateTime();
                $fileName = $date->format("Ymd_His") . ".wav";

                Storage::put('public/tmp/' . $fileName, $recording);

                $basePath = App::basePath();

                $file = $basePath . "\\storage\\app\\public\\tmp\\" . $fileName;

                return response()->download($file);    
            } else{
                $text = 'Missing file from Hermes: ' . $fileDB->fileName ; 
                SearchHelper::DebuggerTxT($text);
                Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
            }
        } else {
            $text = 'FTP server is offline' ; 
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }
    }

    public function getDownloadRecordingSearch(Request $request, int $id)
    {
        SearchHelper::UsersActions();
        $fileDB = RecordingSearch::find($id);

        if(Storage::disk('ftp_hermes')->exists($fileDB->path)){

            $recording = Storage::disk('ftp_hermes')->get($fileDB->path);
            
            $date = new DateTime();
            //$fileName = $date->format("Ymd_His") . ".wav";
            $fileName = $fileDB->filename;

            Storage::put('public/tmp/' . $fileName, $recording);

            $basePath = App::basePath();

            $file = $basePath . "\\storage\\app\\public\\tmp\\" . $fileName;

            return response()->download($file);

        } else{
            $text = 'Missing file from Hermes at search: ' . $fileDB->filename ; 
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }
    }
/*
    public function getRecording(int $id) {
        $path = (storage_path().$song->path.".mp3");

        $response = new BinaryFileResponse($path);
        BinaryFileResponse::trustXSendfileTypeHeader(); 
        return $response; 

    }
*/
    public function getEcommerceSageFile(Request $request, int $id)
    {
        SearchHelper::UsersActions();
        $fileDB = Recordings::find($id);

        if (file_exists($fileDB->nasPath))
            return response()->download($fileDB->nasPath);
        else{
            $text = 'Missing file from Hermes: ' . $fileDB->fileName ; 
            SearchHelper::DebuggerTxT($text);
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail($text));
        }
    }
}
