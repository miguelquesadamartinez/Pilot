<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Helpers\ScoreHelper;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use Illuminate\Http\Response;
use App\Models\ScoreLaboratory;
use App\Models\Ecommerce\Pharmacy;
use Illuminate\Support\Facades\DB;
use App\Models\Ecommerce\Laboratory;
use App\Models\ScoreLaboratoryScore;

class ScoresController extends Controller
{
    public function pharmacies (){
/*
        $sql = "
                select * from [ECOMMERCE].dbo.[pharmacy] p join [Pilot].dbo.[scores] sc on p.id = sc.pharmacy_id
                where exists (select 1 from [Pilot].dbo.[scores] s
                                where s.pharmacy_id = p.id
                            ) 
                and p.[deleted_at] is null
                and sc.score is not null
                order by sc.updated_at desc
        ";

        $pharmacyExists = DB::connection('sqlsrv')->select($sql);
*/
        SearchHelper::UsersActions();
        $scoreExists = Score::paginate(25);
        return view('score.scoresList', compact('scoreExists'));
        // For shared blade
        //$fromList = true;
        //return view('score.pharmacies', compact('pharmacyExists', 'fromList'));

    }
    public function laboratories (){
        $laboratories = Laboratory::all();
        // Por cada laboratorio de ecommerce, comprobamos que tenga el registro que indica que esta activa o no, y si no esta lo creamos
        // Despues, los mostramos todos, asi es como nos aseguramos que cuando vayan a activar una farmacia el registro ya este
        foreach($laboratories as $lab){
            $lab_enabled = ScoreLaboratory::where('laboratory_id', '=', $lab->id)->get();
            if( ! count($lab_enabled) ){
                $store = new ScoreLaboratory();
                $store->laboratory_id = $lab->id;
                $store->save();
            }
        }
        $sql = "select * from [ECOMMERCE].dbo.[laboratory] l join [Pilot].dbo.[score_laboratories] sl on l.id = sl.laboratory_id";
        $laboratories = DB::connection('sqlsrv')->select($sql);
        return view('score.laboratories', compact('laboratories'));
    }
    public function changeStatus(Request $request, int $id){
        $labo = ScoreLaboratory::find($id);
        $labo->enabled = ! $labo->enabled;
        $labo->save();
        ScoreHelper::reCalculateScores();
        return redirect('/scoring/laboratories');
    }
    public function search(Request $request){
        //ToDo: Chapuza
        // Esto es porque la paginacion llega aqui como get, le puse any en la ruta, y esto me funciono, se podria mejorar
        if(Isset($request->page)){
            $searchText = session()->get('search_string_score');
        } else {
            $searchText = trim($request->searchText);
        }
        if($searchText != ''){
            session()->put('search_string_score', $searchText);
        }
        $pharmacyExists = Pharmacy::where('name', 'like', '%' . $searchText . '%')
                        ->orWhere('business_name', 'like', '%' . $searchText . '%')
                        ->orWhere('cip', 'like', '%' . $searchText . '%')
                        ->orWhere('phone', 'like', '%' . $searchText . '%')
                        ->orWhere('email', 'like', '%' . $searchText . '%')
                        ->orderBy('name', 'asc')
                        ->paginate(25);
        return view('score.pharmacies', compact('pharmacyExists'));
    }
    public function pharmacyScoring (Request $request, int $id){

        $sql = "SELECT s.*, p.name, p.id as pharm_id
        FROM [PILOT].[dbo].[scores] s
        Join ECOMMERCE.dbo.pharmacy p on s.pharmacy_id = p.id
        where s.pharmacy_id = " . $id;
        $score = DB::connection('sqlsrv')->select($sql);
        if ( ! isset( $score[0]->pharmacy_id ) ){
            $score = new Score();
            $score->pharmacy_id = $id;
            $score->manual = 0;
            $score->score = 0;
            $score->save();
        } else {
            $score = $score[0];
        }
        $labs = ScoreLaboratory::all();
        //Para cada puntuacion de laboratorio, si no tiene el registro para la puntuacion de algun laboratorio, lo crea
        foreach($labs as $lab){
            $laby = ScoreLaboratoryScore::where('pharmacy_id', '=', $id)
                                            ->where('laboratory_id', '=', $lab->laboratory_id)
                                            ->get();
            if ( ! count($laby)){
                $SLS = new ScoreLaboratoryScore();
                $SLS->laboratory_id = $lab->laboratory_id;
                $SLS->pharmacy_id = $id;
                $SLS->score = 0;
                $SLS->save();
            }
        }
        $scores = ScoreLaboratoryScore::where('pharmacy_id', '=', $id)
        ->join('score_laboratories', 'score_laboratories.laboratory_id', '=','score_laboratory_scores.laboratory_id')
        ->get();
        if ( session()->get('success_score') == '1')
            $success = 'score edited';
        else
            $success = null;
        session()->put('success_score', '0');
        return view('score.scoring', compact('score', 'success', 'scores'));
    }
    public function updateScore(Request $request){
        $request->validate([
            'manual_enter' => 'required|integer|between:-10,10',
        ]);
        $score = Score::find($request->score_id);
        $score->manual = $request->manual_enter;
        $scoresPharmacy = ScoreLaboratoryScore::join('score_laboratories', 'score_laboratories.laboratory_id', '=', 'score_laboratory_scores.laboratory_id')
                                                ->where('score_laboratory_scores.pharmacy_id', '=', $request->pharmacy_id)
                                                ->where('score_laboratories.enabled', '=', true)
                                                ->get();
        //ToDo: Calculation
        $cnt = 0;
        $tempVal = 0;
        foreach($scoresPharmacy as $var){
            $tempVal += $var->score;
            $cnt ++;
        }
        if($tempVal != 0){
            $media = $tempVal / $cnt;
            $media = $media + $request->manual_enter ;
            $score->score = number_format($media, 1);
        } else {
            $score->score = $request->manual_enter;
        }
        $score->save();
        session()->put('success_score', '1');
        return redirect('/scoring/pharmacy-scoring/' . $request->pharmacy_id);
    }
    public function getScore(int $pharmacy){
        $farmacia = Pharmacy::find($pharmacy);
        if ( Isset($farmacia->scoreObj->score) ) {
            $arr = [
                'score' => number_format($farmacia->scoreObj->score, 1),
                'manual' => $farmacia->scoreObj->manual,
                'name' => $farmacia->name,
                'cip' => $farmacia->cip
            ];
            $scores = ScoreLaboratoryScore::join('score_laboratories', 'score_laboratories.laboratory_id', '=', 'score_laboratory_scores.laboratory_id')
                                         ->where('score_laboratories.enabled', '=', true)
                                         ->where('score_laboratory_scores.pharmacy_id', '=', $pharmacy)
                                         ->get();
            foreach($scores as $sc) {
                $temp = [ Laboratory::find($sc->laboratory_id)->name => round($sc->score) ];
                $arr = $arr + $temp;
            }
            return response()->json(
                $arr,
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'error' => '404',
                    'score' => 'Not found'
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
    public function updateScoreForPharmacy(Request $request, string $pharmacy, string $laboratory, string $score_p){
        if ( ! is_numeric($pharmacy) ) {
            return response()->json(
                [
                    'error' =>'Pharmacy ID not valid, must be a number'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        if ( ! is_numeric($laboratory) ) {
            return response()->json(
                [
                    'error' =>'Laboratory ID not valid, must be a number'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        if ( ! is_numeric($score_p) ) {
            return response()->json(
                [
                    'error' =>'Score not valid, must be a number'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        if ($score_p > 10 || $score_p < -10){
            return response()->json(
                [
                    'error' =>'Score not valid, must be between 10 and -10'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        // Check if pharmacy exists
        if ( ! count( Pharmacy::where('id', '=', $pharmacy)->get() ) ){
            return response()->json(
                [
                    'error' =>'Pharmacy not exists'
                ],
                Response::HTTP_NOT_FOUND
            );
        }
        // Check if laboratory exists
        if ( ! count( Laboratory::where('id', '=', $laboratory)->get() ) ){
            return response()->json(
                [
                    'error' =>'Laboratory not exists'
                ],
                Response::HTTP_NOT_FOUND
            );
        }       
        $sql = "SELECT s.*, p.name, p.id as pharm_id
        FROM [PILOT].[dbo].[scores] s
        Join ECOMMERCE.dbo.pharmacy p on s.pharmacy_id = p.id
        where pharmacy_id = " . $pharmacy;
        if ( ! isset( DB::connection('sqlsrv')->select($sql)[0]->pharmacy_id ) ){
            $score = new Score();
            $score->pharmacy_id = $pharmacy;
            $score->manual = 0;
            $score->score = 0;
            $score->save();
        }
        $labs = ScoreLaboratory::all();
        // Crea los registros inexistentes, si los hay, de las notas por laboratorio de la farmacia
        foreach($labs as $lb){
            $laby = ScoreLaboratoryScore::where('pharmacy_id', '=', $pharmacy)
                                        ->where('laboratory_id', '=', $lb->laboratory_id)
                                        ->get();
            if ( ! count($laby) ){
                $SLS = new ScoreLaboratoryScore();
                $SLS->laboratory_id = $lb->laboratory_id;
                $SLS->pharmacy_id = $pharmacy;
                $SLS->score = 0;
                $SLS->save();
            }
        }
        // Ahora busco el registro que vamos a actualizar
        $score_a = ScoreLaboratoryScore::where('pharmacy_id', '=', $pharmacy)
                                        ->where('laboratory_id', '=', $laboratory)
                                        ->get();
        $theScore = Score::where('pharmacy_id', '=', $pharmacy)->get();
        $score_save = ScoreLaboratoryScore::find($score_a[0]->id);
        $score_save->score = $score_p;
        $score_save->save();
        // Vamos a recalcular la nota final de esta farmacia
        $scoresPharmacy = ScoreLaboratoryScore::join('score_laboratories', 'score_laboratories.laboratory_id', '=', 'score_laboratory_scores.laboratory_id')
                                                ->where('score_laboratory_scores.pharmacy_id', '=', $pharmacy)
                                                ->where('score_laboratories.enabled', '=', true)
                                                ->get();
        $score_temp = Score::where('pharmacy_id', '=', $pharmacy)->get();
        $score = Score::find($score_temp[0]->id);
        //ToDo: Calculation
        $cnt = 0;
        $tempVal = 0;
        foreach($scoresPharmacy as $var){
            $tempVal += $var->score;
            $cnt ++;
        }
        if($cnt > 0){
            $media = $tempVal / $cnt;
            $media = $media + ( (int)$theScore[0]->manual );
            $score->score = number_format($media, 1);
        } else {
            $score->score = $theScore[0]->manual;
        }
        $score->save();
        return response()->json(
            [
                'score' => $score->score
            ],
            Response::HTTP_OK
        );
    }
}
