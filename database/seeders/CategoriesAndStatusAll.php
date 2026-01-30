<?php

namespace Database\Seeders;

use App\Models\tickets_level_a;
use App\Models\tickets_level_b;
use App\Models\tickets_level_c;
use App\Models\TicketStatus;
use App\Models\TicketCategories;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesAndStatusAll extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ticket_categories')->insert([
            'category_en' => 'False order',
            'category_es' => 'Pedido falso',
            'category_fr' => 'Fausse commande',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Wrong Quantity',
            'category_es' => 'Cantidad incorrecta',
            'category_fr' => 'Mauvaise quantité',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Duplicated order receipt',
            'category_es' => 'Recibo de pedido duplicado',
            'category_fr' => 'Reçu de commande en double',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Late order received refused',
            'category_es' => 'Pedido recibido tarde rechazado',
            'category_fr' => 'Commande reçue en retard refusée',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Delivery Error',
            'category_es' => 'Error de entrega',
            'category_fr' => 'Erreur de livraison',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        $false = TicketCategories::where('category_en', '=', 'False order')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Reading the Sale Record',
            'status_es' => 'Leer el registro de venta',
            'status_fr' => 'Lecture du procès-verbal de vente',
            'category_id' => $false[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Validation or not of the order',
            'status_es' => 'Validación o no del pedido',
            'status_fr' => 'Validation ou non de la commande',
            'category_id' => $false[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Real Fake Order',
            'status_es' => 'Orden falsa real',
            'status_fr' => 'Vraie fausse commande',
            'category_id' => $false[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        
        $wrong = TicketCategories::where('category_en', '=', 'Wrong Quantity')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Product Lack',
            'status_es' => 'Falta de stock de producto',
            'status_fr' => 'Manque de stock de produits',
            'category_id' => $wrong[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Product is missing',
            'status_es' => 'Falta el producto',
            'status_fr' => 'Le produit est manquant',
            'category_id' => $wrong[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Order not received',
            'status_es' => 'Pedido no recibido',
            'status_fr' => 'Commande non reçu',
            'category_id' => $wrong[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $duplicate = TicketCategories::where('category_en', '=', 'Duplicated order receipt')->get();
/*
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Closed',
            'status_es' => 'Cerrado',
            'status_fr' => 'Fermé',
            'category_id' => $duplicate[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);
*/

        $late = TicketCategories::where('category_en', '=', 'Late order received refused')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Logistics Entry Entered Returns by GLS Number',
            'status_es' => 'Entrada logística Devoluciones ingresadas por número GLS',
            'status_fr' => 'Saisie logistique Retours saisis par numéro GLS',
            'category_id' => $late[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Order returns not received by BN',
            'status_es' => 'Devoluciones de pedidos no recibidas por BN',
            'status_fr' => 'Retours de commande non reçus par BN',
            'category_id' => $late[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $delivery = TicketCategories::where('category_en', '=', 'Delivery Error')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Delivered to another pharmacy',
            'status_es' => 'Entregado en otra farmacia',
            'status_fr' => 'Livré dans une autre pharmacie',
            'category_id' => $delivery[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_statuses')->insert([
            'status_en' => 'GLS delivers with good label and wrong address',
            'status_es' => 'GLS entrega con buena etiqueta y dirección incorrecta',
            'status_fr' => 'GLS livre avec une bonne étiquette et une mauvaise adresse',
            'category_id' => $delivery[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Double billing',
            'category_es' => 'Doble facturación',
            'category_fr' => 'Double facturation',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Clubbiogyne Problem',
            'category_es' => 'Clubbiogyne Problema',
            'category_fr' => 'Clubbiogyne Problème',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
            'type_id'     => '1',
            'active'      => true,
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

        $var = TicketCategories::where('category_en', '=', 'Direct debit 2 times')->get();

        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Credit Memo - Direct debit 2 times',
            'level_a_es' => 'Nota de crédito',
            'level_a_fr' => 'Note de crédit',
            'status_id' => $var[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        $var = TicketCategories::where('category_en', '=', 'Direct debit 2 times')->get();

        DB::table('ticket_statuses')->insert([
            'status_en' => 'Credit Memo - Direct debit 2 times',
            'status_es' => 'Nota de crédito',
            'status_fr' => "Note de crédit",
            'category_id' => $var[0]->id,
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        tickets_level_a::find(11)->delete();

    }
}
