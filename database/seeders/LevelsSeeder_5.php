<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use App\Models\tickets_level_a;
use App\Models\tickets_level_b;
use App\Models\tickets_level_c;
use Illuminate\Database\Seeder;
use App\Models\TicketCategories;
use Illuminate\Support\Facades\DB;


class LevelsSeeder_5 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $var = TicketCategories::where('category_en', '=', 'Direct debit 2 times')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Credit Memo - Direct debit 2 times',
            'status_es' => 'Nota de crédito',
            'status_fr' => "Note de crédit",
            'category_id' => $var[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

    }
}
