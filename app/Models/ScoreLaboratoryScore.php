<?php

namespace App\Models;

use App\Models\Ecommerce\Laboratory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreLaboratoryScore extends Model
{
    use HasFactory;


    public function laboratory()
    {
        return Laboratory::where('id', '=', $this->laboratory_id)->get();
    }

    public function getLaboratoryName()
    {
        return Laboratory::where('id', '=', $this->laboratory_id)->get()[0]->name;
    }
}
