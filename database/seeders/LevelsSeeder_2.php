<?php

namespace Database\Seeders;

use App\Models\tickets_level_a;
use App\Models\tickets_level_b;
use App\Models\tickets_level_c;
use App\Models\TicketStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LevelsSeeder_2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $missing = TicketStatus::where('status_en', '=', 'Product is missing')->get();

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Missing product (Invoiced)',
            'level_a_es' => 'Producto faltante (Facturado)',
            'level_a_fr' => 'Produit manquant (Facturé)',
            'status_id' => $missing[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Missing product (Not invoiced)',
            'level_a_es' => 'Producto faltante (No facturado)',
            'level_a_fr' => 'Produit manquant (Non facturé)',
            'status_id' => $missing[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);
        
        $not_received = TicketStatus::where('status_en', '=', 'Order not received')->get();

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Disruptive product',
            'level_a_es' => 'Producto disruptivo',
            'level_a_fr' => 'Produit disruptif',
            'status_id' => $not_received[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);


        $invoiced = tickets_level_a::where('level_a_en', '=', 'Missing product (Invoiced)')->get();

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Customer insists – 1st time',
            'level_b_es' => 'El cliente insiste - Primera vez',
            'level_b_fr' => 'Le client insiste – 1ère fois',
            'level_a_id' => $invoiced[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Customer insists – 2nd time',
            'level_b_es' => 'El cliente insiste - Segunda vez',
            'level_b_fr' => 'Le client insiste – 2ème fois',
            'level_a_id' => $invoiced[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Customer refusal - Invoiced',
            'level_b_es' => 'Negativa del cliente - Facturado',
            'level_b_fr' => 'Refus client - Facturé',
            'level_a_id' => $invoiced[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Voucher validated',
            'level_b_es' => 'Vale validado',
            'level_b_fr' => 'Bon validé',
            'level_a_id' => $invoiced[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $not_invoiced = tickets_level_a::where('level_a_en', '=', 'Missing product (Not invoiced)')->get();

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Order to cancel - Not invoiced',
            'level_b_es' => 'Orden para cancelar',
            'level_b_fr' => 'Commande à annuler',
            'level_a_id' => $not_invoiced[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Seized product',
            'level_b_es' => 'Producto incautado',
            'level_b_fr' => 'Produit saisi',
            'level_a_id' => $not_invoiced[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Product not entered',
            'level_b_es' => 'Producto no ingresado',
            'level_b_fr' => 'Produit non renseigné',
            'level_a_id' => $not_invoiced[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);


        $disruptive = tickets_level_a::where('level_a_en', '=', 'Disruptive product')->get();

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Order to cancel - Disruptive',
            'level_b_es' => 'Orden para cancelar',
            'level_b_fr' => 'Commande à annuler',
            'level_a_id' => $disruptive[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => 'Urgent shipment',
            'level_b_es' => 'Envío urgente',
            'level_b_fr' => 'Expédition urgente',
            'level_a_id' => $disruptive[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);


        $seized = tickets_level_b::where('level_b_en', '=', 'Seized product')->get();

        DB::table('tickets_level_cs')->insert([
            'level_c_en' => 'Propose new order - Seized',
            'level_c_es' => 'Proponer nuevo orden',
            'level_c_fr' => 'Proposer une nouvelle commande',
            'level_b_id' => $seized[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('tickets_level_cs')->insert([
            'level_c_en' => 'Returns missing product',
            'level_c_es' => 'Devuelve producto faltante',
            'level_c_fr' => 'Retourne le produit manquant',
            'level_b_id' => $seized[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $not_entered = tickets_level_b::where('level_b_en', '=', 'Product not entered')->get();

        DB::table('tickets_level_cs')->insert([
            'level_c_en' => 'Propose new order - Not entered',
            'level_c_es' => 'Proponer nuevo orden',
            'level_c_fr' => 'Proposer une nouvelle commande',
            'level_b_id' => $not_entered[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

    }
}
