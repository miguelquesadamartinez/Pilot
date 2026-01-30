<?php

namespace App\Helpers;

use App\Models\Score;
use App\Models\ScoreLaboratory;
use App\Models\ScoreLaboratoryScore;

class ScoreHelper {

    public static function reCalculateScores () {

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));

        $scores = Score::all();
        $labs = ScoreLaboratory::all();

        // Para cada puntuacion general de laboratorio, si la farmacia de la puntuacion no tiene el registro para la puntuacion de algun laboratorio, 
        // lo crea, por si se añadio laboratorio

        foreach($scores as $sc){
            foreach($labs as $lb){
                $laby = ScoreLaboratoryScore::where('pharmacy_id', '=', $sc->pharmacy_id)
                                                ->where('laboratory_id', '=', $lb->laboratory_id)
                                                ->get();
                
                if ( ! count($laby) ){
                    $SLS = new ScoreLaboratoryScore();
                    $SLS->laboratory_id = $lb->laboratory_id;
                    $SLS->pharmacy_id = $sc->pharmacy_id;

                    $SLS->score = 0;

                    $SLS->save();
                }
            }
        }

        // Recalculamos todas las medias de cada score, segun 
        foreach($scores as $sc){
            $score = Score::find($sc->id);
            $scoresPharmacy = ScoreLaboratoryScore::join('score_laboratories', 'score_laboratories.laboratory_id', '=', 'score_laboratory_scores.laboratory_id')
                                                    ->where('score_laboratory_scores.pharmacy_id', '=', $sc->pharmacy_id)
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
                $media = $media + $sc->manual ;
                $score->score = number_format($media, 1);
            } else {
                $score->score = $sc->manual;
            }
            $score->save();
        }        
    }
}
