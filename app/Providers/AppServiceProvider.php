<?php

namespace App\Providers;

use App\Models\Todos;
use App\Models\TicketStatus;
use App\Models\TicketCategories;
use App\Models\Ecommerce\Laboratory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Shared variables for the application
/*
        View::share('todosDB', 
                                Todos::where('error', '=', '1')
                                ->orderBy('created_at', 'desc')
                                ->limit(10)
                                ->get()
                    );

        View::share( 'countTodosDb' , Count(Todos::where('error', '=', '1')->get()) );
*/
        //ToDo: Remove this from here
        View::share( 'laboratories_glb' , Laboratory::orderBy('name', 'asc')->get() );
        View::share( 'categories_glb' , TicketCategories::all() );
        View::share( 'status_glb' , TicketStatus::all() );

        Paginator::useBootstrap();

    }
}

