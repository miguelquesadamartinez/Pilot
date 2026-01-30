<?php

namespace App\Http\Controllers;

use App\Models\Recordings;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;

class RecordingController extends Controller
{
    
    public function RecordingsChangeStatus (Request $request, int $record_id, int $order_id) {

        SearchHelper::UsersActions();

        $record = Recordings::find($record_id);
        $record->selected = ! $record->selected;
        $record->save();

        session()->put('updated_recording', true);

        return redirect('/order/view-order/' . $order_id);
    }
    
}
