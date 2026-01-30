<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Recovery;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use App\Models\Ecommerce\Laboratory;
use App\Models\Ecommerce\Pharmacy;
use Illuminate\Support\Facades\App;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\PharmacyLaboratoryRestricted;

class RecoveryController extends Controller
{
    public function blockedCustomers(){ 
        SearchHelper::UsersActions();
        if (session()->get('msg') == 'documents_added'){
            $success = 'documents_added';
            session()->put('msg', '');
        } else if (session()->get('msg') == 'documents_deleted'){
            $success = 'documents_deleted';
            session()->put('msg', '');
        } else {
            $success = null;
        }
        
        $used_lab = 0;
        $used_lab_delete = 0;
        $labName = __('All');
        if (session()->get('used_lab')){
            $used_lab = session()->get('used_lab');
            session()->forget('used_lab');
            $lab = Laboratory::find($used_lab);
            if (isset($lab->name)) $labName = $lab->name;
            $pharmacies = PharmacyLaboratoryRestricted::where('laboratory_id', '=', $used_lab)->orderBy('cip', 'asc')->paginate(25);
        } else if (session()->get('used_lab_delete')){
            $used_lab_delete = session()->get('used_lab_delete');
            session()->forget('used_lab_delete');
            $lab = Laboratory::find($used_lab_delete);
            if (isset($lab->name)) $labName = $lab->name;
            $pharmacies = PharmacyLaboratoryRestricted::where('laboratory_id', '=', $used_lab_delete)->orderBy('cip', 'asc')->paginate(25);
        } else {
            $pharmacies = PharmacyLaboratoryRestricted::
                                                        //where('laboratory_id', '=', 6)->
                                                        orderBy('cip', 'asc')->
                                                        paginate(25);
        }
        return view('admin.recovery.main', compact('pharmacies', 'success', 'used_lab', 'used_lab_delete', 'labName')); 
    }

    public function addFile(Request $request) {
        $notFoundPharmacies = Array();
        SearchHelper::UsersActions();
        $cnt = 0;
        $request->validate([
            'add_file' => 'required',
            'used_lab' => 'required',
        ]);
        //$used_lab = $request->used_lab;

        $seleccionados = $request->input('used_lab');

        if ($request->hasFile('add_file')) {
            $file = $request->file('add_file');
            if (!$file->isValid() || !in_array($file->getClientOriginalExtension(), ['xls', 'xlsx'])) {
                return response()->json(['error' => 'El archivo debe ser de tipo XLS o XLSX.'], 400);
            }
            $spreadsheet = IOFactory::load($file->getPathName());
            $writer = IOFactory::createWriter($spreadsheet, 'Csv');
            $writer->setDelimiter(';');
            $csvFileName = storage_path('app/converts/'.$file->getClientOriginalName().'.csv');
            $writer->save($csvFileName);
            if (($handle = fopen(storage_path('app/converts/'.$file->getClientOriginalName().'.csv'), "r")) !== FALSE) {
                while (($line = fgetcsv($handle, null, ";")) !== FALSE) {
                    if ($cnt > 0 ){
                        if (is_array($seleccionados) && count($seleccionados) > 0) {
                            foreach($seleccionados as $used_lab){
                
                                $pharmacy = Pharmacy::where('cip', '=', $line[1])->get();
                                if (isset($pharmacy[0]->id)){
                                    $check = PharmacyLaboratoryRestricted::where('cip', '=', $line[1])
                                                                        ->where('laboratory_id', '=', $used_lab)
                                                                        ->get();
                                    if( ! count($check) ){
                                        $farm = new PharmacyLaboratoryRestricted();
                                        $farm->cip = $line[1];
                                        $farm->laboratory_id = $used_lab;
                                        $farm->save();
                                    }
                                    $return = SearchHelper::getDataForRecovery($line);
                                    $check = Recovery::where('pharmacy_id', '=',$pharmacy[0]->id)
                                                    ->where('date_operation', '=', $return['date_operation'])
                                                    ->where('facture', '=', $return['invoice'])
                                                    ->where('libelle_rejet', '=', $return['libelle_rejet'])
                                                    ->where('montant', '=',  str_replace(',', '', $line[7]) )
                                                    ->get();         
                                    if( ! count($check) ){
                                        $reco = new Recovery();
                                        $reco->pharmacy_id = $pharmacy[0]->id;
                                        $reco->date_operation = $return['date_operation'];
                                        $reco->facture = $return['invoice'];
                                        $reco->libelle_rejet = $return['libelle_rejet'];
                                        $reco->montant = str_replace(',', '', $line[7]);
                                        $reco->count_litige = 0;
                                        $reco->save();
                                    }
                                } else {
                                    $notFoundPharmacies[$line[1]] = $line[1];
                                }
                            }
                        }
                    }
                    $cnt++;
                }
            }
            unlink(App::basePath() . "\\storage\\app\\converts\\" .$file->getClientOriginalName().'.csv');
            session()->put('msg', 'documents_added');
            return redirect('/recovery/blocked-customers');
        }
    }

    public function deleteFile(Request $request) {
        SearchHelper::UsersActions();
        $notFoundPharmacies = Array();
        $cnt = 0;
        $request->validate([
            'delete_file' => 'required',
        ]);
        $used_lab_delete = $request->used_lab_delete;
        session()->put('used_lab_delete', $used_lab_delete);
        if ($request->hasFile('delete_file')) {
            $file = $request->file('delete_file');
            if (!$file->isValid() || !in_array($file->getClientOriginalExtension(), ['xls', 'xlsx'])) {
                return response()->json(['error' => 'El archivo debe ser de tipo XLS o XLSX.'], 400);
            }
            $spreadsheet = IOFactory::load($file->getPathName());
            $writer = IOFactory::createWriter($spreadsheet, 'Csv');
            $writer->setDelimiter(';');
            $csvFileName = storage_path('app/converts/'.$file->getClientOriginalName().'.csv');
            $writer->save($csvFileName);
            if (($handle = fopen(storage_path('app/converts/'.$file->getClientOriginalName().'.csv'), "r")) !== FALSE) {
                while (($line = fgetcsv($handle, null, ";")) !== FALSE) {
                    if ($cnt > 0 ){
                        $pharmacy = Pharmacy::where('cip', '=', $line[1])->get();
                        if (isset($pharmacy[0]->id)){
                            $farms = PharmacyLaboratoryRestricted::where('cip', '=', $line[1])->get();
                            foreach ($farms as $farm){
                                PharmacyLaboratoryRestricted::find($farm->id)->delete();
                            }
                            $return = SearchHelper::getDataForRecovery($line);
                            $recoveries = Recovery::where('pharmacy_id', '=', $pharmacy[0]->id)
                                            ->where('date_operation', '=', $return['date_operation'])
                                            ->where('facture', '=', $return['invoice'])
                                            ->where('libelle_rejet', '=', $return['libelle_rejet'])
                                            ->where('montant', '=', str_replace(',', '', $line[7]))
                                            ->get();
                            foreach ($recoveries as $reco){
                                Recovery::find($reco->id)->delete();
                            }
                        } else {
                            $notFoundPharmacies[$line[1]] = $line[1];
                        }
                    }
                    $cnt++;
                }
            }
            unlink(App::basePath() . "\\storage\\app\\converts\\" .$file->getClientOriginalName().'.csv');
            session()->put('msg', 'documents_deleted');
            return redirect('/recovery/blocked-customers');
        }
    }
}
