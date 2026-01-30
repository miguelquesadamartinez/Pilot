<?php

namespace Database\Seeders;

use App\Models\TicketCategories;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesAndStatus extends Seeder
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
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Wrong Quantity',
            'category_es' => 'Cantidad incorrecta',
            'category_fr' => 'Mauvaise quantité',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Duplicated order receipt',
            'category_es' => 'Recibo de pedido duplicado',
            'category_fr' => 'Reçu de commande en double',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Late order received refused',
            'category_es' => 'Pedido recibido tarde rechazado',
            'category_fr' => 'Commande reçue en retard refusée',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Delivery Error',
            'category_es' => 'Error de entrega',
            'category_fr' => 'Erreur de livraison',
            'created_at'  => date(app('global_format_date').' 00:00:00'),
            'updated_at'  => date(app('global_format_date').' 00:00:00'),
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

    }
}
