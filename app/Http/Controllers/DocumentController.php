<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use Illuminate\Support\Facades\App;

class DocumentController extends Controller
{
    
    public function main(){

        SearchHelper::UsersActions();

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
        $limitDate = $currentDate->subMonth();

        $documents = Document::orderBy('created_at', 'desc')->paginate(10);

        $status_var = "";

        return view('documents.main', compact('documents', 'success', 'status_var'));
    }

    public function mainActive(){

        $currentDate = now();
        $limitDate = $currentDate->subMonth();

        $documents = Document::where('active' ,'=', '1')
                            ->orderBy('created_at', 'desc')
                            //->paginate(25)
                            ->get()
                            ;

        $status_var = "";
        $success = null;

        return view('documents.mainActive', compact('documents', 'success', 'status_var'));
    }

    public function newDocument(){

        $document = null;

        return view('documents.editdocument', compact('document'));
    }


    public function createDocument(Request $request) {

        $request->validate([
            'name' => 'required',
            'document_file' => 'required',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
        } 

        $document = new Document();

        $document->name = $request->name;
        $document->version = $request->version;
        $document->date = $request->date;

        if ($request->active == 'on'){
            $document->active = true;
        } else {
            $document->active = false;
        }
        
        $document->fileName = $file->getClientOriginalName();

        $document->created_at = date(app('global_format_date'));
        $document->updated_at = date(app('global_format_date'));

        $document->save(); // Para que saque el id

        $document->filePath = '//document_uploads/' . $document->id .'/' . $file->getClientOriginalName() ;

        $document->save();

        $request->document_file->storeAs('document_uploads/' . $document->id .'/' , $file->getClientOriginalName(), 'public');

        session()->put('msg', 'doc created');

        return redirect('/documents-edit-document/' . $document->id);

    }

    public function editDocument(Request $request, int $id){

        $success = null;
        if(session()->get('msg') != ''){
            $success = session()->get('msg');
            session()->forget('msg');
        }

        $document = Document::find($id);

        return view('documents.editdocument', compact('document', 'success'));
    }

    public function updateDocument(Request $request) {

        $request->validate([
            'name' => 'required',
            'document_id' => 'required',
            //'document_file' => 'required',
        ]);

        $document = Document::find($request->document_id);

        $document->name = $request->name;
        $document->version = $request->version;
        $document->date = $request->date;

        if ($request->active == 'on'){
            $document->active = true;
        } else {
            $document->active = false;
        }

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');

            if($document->fileName != ''){
                $file_path = App::basePath() . '/storage/app/public/document_uploads/'. $document->id .'/' .$document->fileName;

                if ( file_exists($file_path) )
                    unlink($file_path);
            }

            $document->fileName = $file->getClientOriginalName();
            $document->filePath = '//document_uploads/' . $document->id .'/' . $file->getClientOriginalName() ;

            $request->document_file->storeAs('document_uploads/' . $document->id .'/' , $file->getClientOriginalName(), 'public');
        }

        $document->created_at = date(app('global_format_date'));
        $document->updated_at = date(app('global_format_date'));

        $document->save();

        session()->put('msg', 'doc edited');

        return redirect('/documents-edit-document/' . $document->id);

    }

    public function deleteFile(Request $request, int $id) {

        $document = Document::find($id);

        $file_path = App::basePath() . '/storage/app/public/document_uploads/'. $document->id .'/' .$document->fileName;
        unlink($file_path);

        $document->fileName = '';
        $document->filePath = '';

        $document->save();

        session()->put('msg', 'file deleted');

        return redirect('/documents-edit-document/' . $document->id);
    
    }

    public function documentSearch(Request $request) {

        $currentDate = now();
        $limitDate = $currentDate->subMonth();

        $documents = Document::where('name' ,'like', '%' . $request->search . '%' )
                            ->orWhere('version' ,'like', '%' . $request->search . '%' )
                            ->orWhere('fileName' ,'like', '%' . $request->search . '%' )
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        $status_var = "";
        $success = null;

        $search = $request->search;

        return view('documents.main', compact('documents', 'success', 'status_var', 'search'));

    }

}
