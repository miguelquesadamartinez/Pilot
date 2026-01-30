<?php

namespace App\Http\Controllers;

use App\Models\Todos;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Dashboard (){

        //$todos = Todos::get();
        $todos = null;

        // This is for links at the blade to Order Controller
        $controllerPath = env('CONTROLLER_PATH');

        return view('dashboard', compact('todos', 'controllerPath'));

    }
}
