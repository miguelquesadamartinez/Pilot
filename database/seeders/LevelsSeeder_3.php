<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use App\Models\tickets_level_a;
use App\Models\tickets_level_b;
use App\Models\tickets_level_c;
use Illuminate\Database\Seeder;
use App\Models\TicketCategories;
use Illuminate\Support\Facades\DB;


class LevelsSeeder_3 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /* CATEGORIAS */

        DB::table('ticket_categories')->insert([
            'category_en' => 'Order not delivered',
            'category_es' => 'Pedidos no entregados',
            'category_fr' => 'Commandes non livrées',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Missing Item',
            'category_es' => 'Elemento faltante',
            'category_fr' => 'Élément manquant',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);
/*
        DB::table('ticket_categories')->insert([
            'category_en' => 'Delivery error',
            'category_es' => 'Error de entrega',
            'category_fr' => 'Erreur de livraison',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);
*/
        DB::table('ticket_categories')->insert([
            'category_en' => 'Parcel sent several times',
            'category_es' => 'Paquete enviado varias veces',
            'category_fr' => 'Colis envoyé plusieurs fois',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Order modification/cancellation',
            'category_es' => 'Modificación/cancelación de pedido',
            'category_fr' => 'Modification/annulation de commande',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Good buy',
            'category_es' => 'Buena compra',
            'category_fr' => 'Bon achat',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Credit note not received',
            'category_es' => 'Nota de crédito no recibida',
            'category_fr' => 'Note de crédit non reçue',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '2',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Incorrect invoice information',
            'category_es' => 'Información de factura incorrecta',
            'category_fr' => 'Informations de facture incorrectes',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '2',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Direct debit 2 times',
            'category_es' => 'Débito directo 2 veces',
            'category_fr' => 'Prélèvement automatique 2 fois',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '2',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Non-existent customer',
            'category_es' => 'Cliente inexistente',
            'category_fr' => 'Client inexistant',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Connection problem',
            'category_es' => 'Problema de conexión',
            'category_fr' => 'Problème de connexion',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Uncollected credit',
            'category_es' => 'Crédito no cobrado',
            'category_fr' => 'Crédit non recouvré',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);
        

        /* STATUS */
        
        $order_not_delivered = TicketCategories::where('category_en', '=', 'Order not delivered')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Sage non-integrated order',
            'status_es' => 'Orden no integrada de Sage',
            'status_fr' => 'Commande Sage non intégrée',
            'category_id' => $order_not_delivered[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $missing_item = TicketCategories::where('category_en', '=', 'Missing Item')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Unordered item',
            'status_es' => 'Articulo no pedido',
            'status_fr' => 'Article non commandé',
            'category_id' => $missing_item[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $unordered_item = TicketCategories::where('category_en', '=', 'Uncollected credit')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Payment already made',
            'status_es' => 'Pago ya realizado',
            'status_fr' => 'Paiement déjà effectué',
            'category_id' => $unordered_item[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Payment not made',
            'status_es' => 'Pago no realizado',
            'status_fr' => 'Paiement non effectué',
            'category_id' => $unordered_item[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $delivery_error = TicketCategories::where('category_en', '=', 'Delivery error')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Other address',
            'status_es' => 'Otra dirección',
            'status_fr' => 'Autre adresse',
            'category_id' => $delivery_error[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Other pharmacy',
            'status_es' => 'Otra farmacia',
            'status_fr' => 'Autre pharmacie',
            'category_id' => $delivery_error[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Reverse control',
            'status_es' => 'Control inverso',
            'status_fr' => 'Contrôle inverse',
            'category_id' => $delivery_error[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $sent_several = TicketCategories::where('category_en', '=', 'Parcel sent several times')->get();
        
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Duplicate orders',
            'status_es' => 'Pedidos duplicados',
            'status_fr' => 'Commandes en double',
            'category_id' => $sent_several[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Logistical error',
            'status_es' => 'Error logístico',
            'status_fr' => 'Erreur logistique',
            'category_id' => $sent_several[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $incorrecto_info = TicketCategories::where('category_en', '=', 'Incorrect invoice information')->get();
        
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Request for information - Incorrect invoice information',
            'status_es' => 'Solicitud de información',
            'status_fr' => "Demande d'information",
            'category_id' => $incorrecto_info[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $no_exixsts = TicketCategories::where('category_en', '=', 'Non-existent customer')->get();
        
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Request for information - Non-existent customer',
            'status_es' => 'Solicitud de información',
            'status_fr' => "Demande d'information",
            'category_id' => $no_exixsts[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Updated customer - Non-existent customer',
            'status_es' => 'Cliente actualizado',
            'status_fr' => "Client mis à jour",
            'category_id' => $no_exixsts[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $conn_problem = TicketCategories::where('category_en', '=', 'Connection problem')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Request for information - Connection problem',
            'status_es' => 'Solicitud de información',
            'status_fr' => "Demande d'information",
            'category_id' => $conn_problem[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Problem to be corrected',
            'status_es' => 'Problema a corregir',
            'status_fr' => "Problème à corriger",
            'category_id' => $conn_problem[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $good_buy = TicketCategories::where('category_en', '=', 'Good buy')->get();
        
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Incorrect/unavailable',
            'status_es' => 'Incorrecto / no disponible',
            'status_fr' => "Incorrect/indisponible",
            'category_id' => $good_buy[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Updated customer - Good buy',
            'status_es' => 'Cliente actualizado',
            'status_fr' => "Client mis à jour",
            'category_id' => $good_buy[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        /* LEVEL A */

        $sage_non_integrated = TicketStatus::where('status_en', '=', 'Sage non-integrated order')->get();

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'No order',
            'level_a_es' => 'Sin orden',
            'level_a_fr' => 'Pas de commande',
            'status_id' => $sage_non_integrated[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $other_address = TicketStatus::where('status_en', '=', 'Other address')->get();
        
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Return slip',
            'level_a_es' => 'Comprobante de devolución',
            'level_a_fr' => 'Bon de retour',
            'status_id' => $other_address[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $other_pharmacy = TicketStatus::where('status_en', '=', 'Other pharmacy')->get();
        
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Return slip',
            'level_a_es' => 'Comprobante de devolución',
            'level_a_fr' => 'Bon de retour',
            'status_id' => $other_pharmacy[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $reverse_control = TicketStatus::where('status_en', '=', 'Reverse control')->get();

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Return slip',
            'level_a_es' => 'Comprobante de devolución',
            'level_a_fr' => 'Bon de retour',
            'status_id' => $reverse_control[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $log_error = TicketStatus::where('status_en', '=', 'Logistical error')->get();

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Return slip',
            'level_a_es' => 'Comprobante de devolución',
            'level_a_fr' => 'Bon de retour',
            'status_id' => $log_error[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $req_info_1 = TicketStatus::where('status_en', '=', 'Request for information - Incorrect invoice information')->get();

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'New information',
            'level_a_es' => 'Nueva información',
            'level_a_fr' => 'Nouvelles informations',
            'status_id' => $req_info_1[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $req_info_2 = TicketStatus::where('status_en', '=', 'Request for information - Non-existent customer')->get();

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'New information',
            'level_a_es' => 'Nueva información',
            'level_a_fr' => 'Nouvelles informations',
            'status_id' => $req_info_2[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $req_info_3 = TicketStatus::where('status_en', '=', 'Request for information - Connection problem')->get();
       
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'New information',
            'level_a_es' => 'Nueva información',
            'level_a_fr' => 'Nouvelles informations',
            'status_id' => $req_info_3[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $incorrect = TicketStatus::where('status_en', '=', 'Incorrect/unavailable')->get();
        
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Credit Memo - Incorrect/unavailable',
            'level_a_es' => 'Nota de crédito',
            'level_a_fr' => 'Note de crédit',
            'status_id' => $incorrect[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

    }
}
