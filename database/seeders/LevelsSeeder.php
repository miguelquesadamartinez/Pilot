<?php

namespace Database\Seeders;

use App\Models\tickets_level_a;
use App\Models\tickets_level_b;
use App\Models\tickets_level_c;
use App\Models\TicketStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('ticket_categories')->insert([
            'category_en' => 'Double billing',
            'category_es' => 'Doble facturación',
            'category_fr' => 'Double facturation',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Clubbiogyne Problem',
            'category_es' => 'Clubbiogyne Problema',
            'category_fr' => 'Clubbiogyne Problème',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $validation = TicketStatus::where('status_en', '=', 'Validation or not of the order')->get();

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Actual Order',
            'level_a_es' => 'Pedido actual',
            'level_a_fr' => 'Commande réelle',
            'status_id' => $validation[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $actual = tickets_level_a::where('level_a_en', '=', 'Actual Order')->get();

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Customer Accepts Actual order',
            'level_b_es' => 'El cliente acepta - Pedido actual',
            'level_b_fr' => 'Le client accepte - Commande réelle',
            'level_a_id' => $actual[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);
        
        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Customer refusal Actual order',
            'level_b_es' => 'Rechazo del cliente - Pedido actual',
            'level_b_fr' => 'Refus du client - Commande réelle',
            'level_a_id' => $actual[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $accepts = tickets_level_b::where('level_b_en', '=', 'Customer Accepts Actual order')->get();
        
        DB::table('tickets_level_cs')->insert([
            'level_c_en' => 'Yes Accepts Actual order',
            'level_c_es' => 'Si - Acepta - Pedido actual',
            'level_c_fr' => 'Oui - Accepte - Commande réelle',
            'level_b_id' => $accepts[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_cs')->insert([
            'level_c_en' => 'No Accepts Actual order',
            'level_c_es' => 'No - Acepta - Pedido actual',
            'level_c_fr' => 'Non - Accepte - Commande réelle',
            'level_b_id' => $accepts[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $refuses = tickets_level_b::where('level_b_en', '=', 'Customer refusal Actual order')->get();

        DB::table('tickets_level_cs')->insert([
            'level_c_en' => 'Yes refusal Actual order',
            'level_c_es' => 'Si - Rechazo - Pedido actual',
            'level_c_fr' => 'Oui - Refus - Commande réelle',
            'level_b_id' => $refuses[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_cs')->insert([
            'level_c_en' => 'No refusal Actual order',
            'level_c_es' => 'No - Rechazo - Pedido actual',
            'level_c_fr' => 'Non - Refus - Commande réelle',
            'level_b_id' => $refuses[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $no = tickets_level_c::where('level_c_en', '=', 'No Accepts Actual order')->get();

        DB::table('tickets_level_ds')->insert([
            'level_d_en' => 'Customer refusal No Accepts Actual order',
            'level_d_es' => 'Rechazo del cliente - No - Acepta - Pedido actual',
            'level_d_fr' => 'Refus du client - Non - Accepte - Commande réelle',
            'level_c_id' => $no[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_ds')->insert([
            'level_d_en' => 'Customer accepts No Accepts Actual order',
            'level_d_es' => 'El cliente acepta - No - Acepta - Pedido actual',
            'level_d_fr' => 'Le client accepte - Non - Accepte - Commande réelle',
            'level_c_id' => $no[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        
        $yes = tickets_level_c::where('level_c_en', '=', 'Yes refusal Actual order')->get();

        DB::table('tickets_level_ds')->insert([
            'level_d_en' => 'Customer accepts Yes Accepts Actual order',
            'level_d_es' => 'El cliente acepta - Si - Acepta - Pedido actual',
            'level_d_fr' => 'Le client accepte - Oui - Accepte - Commande réelle',
            'level_c_id' => $yes[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_ds')->insert([
            'level_d_en' => 'Customer refusal Yes Accepts Actual order',
            'level_d_es' => 'Rechazo del cliente - Si - Acepta - Pedido actual',
            'level_d_fr' => 'Refus du client - Oui - Accepte - Commande réelle',
            'level_c_id' => $yes[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $no = tickets_level_c::where('level_c_en', '=', 'No refusal Actual order')->get();

        DB::table('tickets_level_ds')->insert([
            'level_d_en' => 'Yes - No refusal Actual order',
            'level_d_es' => 'Si - No - Rechazo - Pedido actual',
            'level_d_fr' => 'Oui - Non - Refus - Commande réelle',
            'level_c_id' => $no[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_ds')->insert([
            'level_d_en' => 'No - No refusal Actual order',
            'level_d_es' => 'No - No - Refusal - Actual order',
            'level_d_fr' => 'Non - Non - Refusal - Actual order',
            'level_c_id' => $no[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

    }
}
