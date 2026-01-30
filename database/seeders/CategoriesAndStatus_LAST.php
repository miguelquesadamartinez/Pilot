<?php

namespace Database\Seeders;

use App\Models\tickets_level_a;
use App\Models\tickets_level_b;
use App\Models\tickets_level_c;
use App\Models\tickets_level_d;
use App\Models\TicketStatus;
use App\Models\TicketCategories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesAndStatus_LAST extends Seeder
{

    /* IA

    Dado este archivo o texto, hay partes con palabras que acaban en "_en" que a la derecha tienen un texto en ingles
    y abajo hay otras acabadas en "_es", y tiene que tener la traduccion al español del texto en ingles
    y mas abajo, acababo en "_fr" tiene que tener la traduccion en frances del texto en ingles
    Y a las traducciones ue tengan: " - ", le quitas todo lo que venga despues incluyendo el " - " que pueden haber varios
    
    */

    public function run(): void
    {

        // # Categories
        // Order

        DB::table('ticket_categories')->insert([
            'category_en' => 'False order',
            'category_es' => 'Pedido falso',
            'category_fr' => 'Fausse commande',
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Product ordered / Reference error',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Order modification or cancellation',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '1',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Partial return selected',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '1',
            'active'      => true,
        ]);

        // Logistics

        DB::table('ticket_categories')->insert([
            'category_en' => 'Order not delivered',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '2',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Preparation error: Missing item',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '2',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Broken / Damaged product',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '2',
            'active'      => true,
        ]);

        /*DB::table('ticket_categories')->insert([
            'category_en' => 'Product returned different from shipped product',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '2',
            'active'      => true,
        ]);*/

        // Billing

        DB::table('ticket_categories')->insert([
            'category_en' => 'Absent IT recording',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Delivery error',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Unrealized credit',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Unreimbursed credit',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Credit not applied',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Incorrect customer information on invoice',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'LCR collected twice',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Voucher not applied',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '3',
            'active'      => true,
        ]);

        DB::table('ticket_categories')->insert([
            'category_en' => 'Disputed logistics charges',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '3',
            'active'      => true,
        ]);

        // Clubbiogyne

        DB::table('ticket_categories')->insert([
            'category_en' => 'Client wants to connect the platform',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '4',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'Client does not exist on the platform',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '4',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'Incorrect client login code',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '4',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'Change email address',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '4',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'The page is not displayed',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '4',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'The voucher is not displayed',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '4',
            'active'      => true,
        ]);

        // Expired product

        DB::table('ticket_categories')->insert([
            'category_en' => 'Excluding promotion offer',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '5',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'With short expiry promotion offer',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '5',
            'active'      => true,
        ]);

        // Other Service

        DB::table('ticket_categories')->insert([
            'category_en' => 'Order declined',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '6',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'Order refused request by the after-sales service',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '6',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'Returned order',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '6',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'Partial order returned',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '6',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'Product returned different from expected product',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '6',
            'active'      => true,
        ]);
        DB::table('ticket_categories')->insert([
            'category_en' => 'Unpaid LCR (no return)',
            'category_es' => '',
            'category_fr' => '',
            'type_id'     => '6',
            'active'      => true,
        ]);

        // # Status

        // Order
        $category_id = TicketCategories::where('category_en', '=', 'False order')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Order made by the customer',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Order NOT made by the customer',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Product ordered / Reference error')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Correct order',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Wrong order',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);

        // Order modification or cancellation - Order
        $category_id = TicketCategories::where('category_en', '=', 'Order modification or cancellation')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'On time - Order modification',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Out of time - Order modification',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);

        // Partial return selected - Order
        $category_id = TicketCategories::where('category_en', '=', 'Partial order returned')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Low price - Partial return selected',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'High price - Partial return selected',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);

        // Logistics

        $category_id = TicketCategories::where('category_en', '=', 'Order not delivered')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Non existant order',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Existent order',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Preparation error: Missing item')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'LCR Paid',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'LCR NOT Paid',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Broken / Damaged product')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Client insists',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Client insists with evidence',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);

        //$category_id = TicketCategories::where('category_en', '=', 'Product returned different from shipped product')->get();

        // Billing

        $category_id = TicketCategories::where('category_en', '=', 'Absent IT recording')->get();
        /*
        DB::table('ticket_statuses')->insert([
            'status_en' => 'xxxxxx',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        */
        $category_id = TicketCategories::where('category_en', '=', 'Delivery error')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'TA error',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'NOT TA error',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Unrealized credit')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Credit not created',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Credit not needed',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Unreimbursed credit')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Payment validation',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Credit not applied')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'LCR Paid - Credit not applied',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'LCR NOT Paid - Credit not applied',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Incorrect customer information on invoice')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Update client information on invoice',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'LCR collected twice')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Dispute confirmed',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Dispute NOT confirmed',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Voucher not applied')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Catalog voucher',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Product voucher',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Disputed logistics charges')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Customer receives catalog voucher',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Checking the registration',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);

        // ClubBiogyne

        //$category_id = TicketCategories::where('category_en', '=', 'Client wants to connect the platform')->get();
        //$category_id = TicketCategories::where('category_en', '=', 'Client does not exist on the platform')->get();
        //$category_id = TicketCategories::where('category_en', '=', 'Incorrect client login code')->get();
        //$category_id = TicketCategories::where('category_en', '=', 'Change email address')->get();
        //$category_id = TicketCategories::where('category_en', '=', 'The page is not displayed')->get();
        $category_id = TicketCategories::where('category_en', '=', 'The voucher is not displayed')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Validated',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Not validated',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Pending',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        // Expired product
        //$category_id = TicketCategories::where('category_en', '=', 'Excluding promotion offer')->get();
        //$category_id = TicketCategories::where('category_en', '=', 'With short expiry promotion offer')->get();
        // Other service
        $category_id = TicketCategories::where('category_en', '=', 'Order declined')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Listen recording',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Order refused request by the after-sales service')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Order refused',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);
        $category_id = TicketCategories::where('category_en', '=', 'Returned order')->get();
        DB::table('ticket_statuses')->insert([
            'status_en' => 'Refund - Returned order',
            'status_es' => '',
            'status_fr' => '',
            'category_id' => $category_id[0]->id,
        ]);


        

        //$category_id = TicketCategories::where('category_en', '=', 'Product returned different from expected product')->get();
        //$category_id = TicketCategories::where('category_en', '=', 'Unpaid LCR (no return)')->get();

        // # Level A

        // Order

        // False order - Order
        $status_id = TicketStatus::where('status_en', '=', 'Order made by customer')->get();
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Customer accepts order',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Customer refuses order',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);
        $status_id = TicketStatus::where('status_en', '=', 'Order NOT made by the customer')->get();
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'QR Code Generation',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);

        // Product ordered / Reference error - Order
        $status_id = TicketStatus::where('status_en', '=', 'Product ordered / Reference error')->get();
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Correct order - error',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);        
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Wrong order - error',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);

        
        // Logistics
        
        // Order not delivered - Logistics
        $status_id = TicketStatus::where('status_en', '=', 'Non existant order')->get();
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Not prepared',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Break up',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Block',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Delivery error',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);

        // The voucher is not displayed - Clubbiogyne
        $status_id = TicketStatus::where('status_en', '=', 'Validated')->get();
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Good buy',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);
        //$status_id = TicketStatus::where('status_en', '=', 'Not validated')->get();
        $status_id = TicketStatus::where('status_en', '=', 'Pending')->get();
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'Expired return',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);

        // Expired product -  none

        /*
        $status_id = TicketStatus::where('status_en', '=', 'xxxxxxx')->get();
        DB::table('tickets_level_as')->insert([
            'level_a_en' => 'xxxxx',
            'level_a_es' => '',
            'level_a_fr' => '',
            'status_id' => $status_id[0]->id,
        ]);
        */

        // # Level B

        $level_a_id = tickets_level_a::where('level_a_en', '=', '')->get();

        DB::table('tickets_level_bs')->insert([
            'level_b_en' => '',
            'level_b_es' => '',
            'level_b_fr' => '',
            'level_a_id' => $level_a_id[0]->id,
        ]);




        // # Level C

        $level_b_id = tickets_level_b::where('level_b_en', '=', '')->get();

        DB::table('tickets_level_cs')->insert([
            'level_c_en' => '',
            'level_c_es' => '',
            'level_c_fr' => '',
            'level_b_id' => $level_b_id[0]->id,
        ]);




        // # Level D

        $level_c_id = tickets_level_c::where('level_c_en', '=', '')->get();

        DB::table('tickets_level_ds')->insert([
            'level_d_en' => '',
            'level_d_es' => '',
            'level_d_fr' => '',
            'level_c_id' => $level_c_id[0]->id,
        ]);




        // # Level E

        $level_d_id = tickets_level_d::where('level_d_en', '=', '')->get();

        DB::table('tickets_level_es')->insert([
            'level_e_en' => '',
            'level_e_es' => '',
            'level_e_fr' => '',
            'level_d_id' => $level_d_id[0]->id,
        ]);

    }
}
