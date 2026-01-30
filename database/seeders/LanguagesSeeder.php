<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use App\Models\tickets_level_a;
use App\Models\tickets_level_b;
use App\Models\tickets_level_c;
use Illuminate\Database\Seeder;
use App\Models\TicketCategories;
use Illuminate\Support\Facades\DB;


class LanguagesSeeder extends Seeder
{
    public function run(): void
    {
        TicketCategories::where('category_en', '=', 'False order')->update(['category_pt' => 'Ordem falsa']);
        TicketCategories::where('category_en', '=', 'Wrong Quantity')->update(['category_pt' => 'Quantidade errada']);
        TicketCategories::where('category_en', '=', 'Duplicated order receipt')->update(['category_pt' => 'Recibo de pedido duplicado']);
        TicketCategories::where('category_en', '=', 'Late order received refused')->update(['category_pt' => 'Pedido atrasado recebido recusado']);
        TicketCategories::where('category_en', '=', 'Delivery Error')->update(['category_pt' => 'Erro de entrega']);
        TicketCategories::where('category_en', '=', 'Double billing')->update(['category_pt' => 'Faturamento duplo']);
        TicketCategories::where('category_en', '=', 'Clubbiogyne Problem')->update(['category_pt' => 'Problema do Clubbiogyne']);

        TicketStatus::where('status_en', '=', 'Reading the Sale Record')->update(['status_pt' => 'Lendo o registro de venda']);
        TicketStatus::where('status_en', '=', 'Validation or not of the order')->update(['status_pt' => 'Validação ou não do pedido']);
        TicketStatus::where('status_en', '=', 'Real Fake Order')->update(['status_pt' => 'Pedido realmente falso']);
        TicketStatus::where('status_en', '=', 'Product Lack')->update(['status_pt' => 'Falta de produto']);
        TicketStatus::where('status_en', '=', 'Product is missing')->update(['status_pt' => 'O produto está faltando']);
        TicketStatus::where('status_en', '=', 'Order not received')->update(['status_pt' => 'Pedido não recebido']);
        TicketStatus::where('status_en', '=', 'Logistics Entry Entered Returns by GLS Number')->update(['status_pt' => 'Entrada de Logística Inserida Devoluções por Número GLS']);
        TicketStatus::where('status_en', '=', 'Order returns not received by BN')->update(['status_pt' => 'Devoluções de pedidos não recebidos pelo BN']);
        TicketStatus::where('status_en', '=', 'Delivered to another pharmacy')->update(['status_pt' => 'Entregue em outra farmácia']);
        TicketStatus::where('status_en', '=', 'GLS delivers with good label and wrong address')->update(['status_pt' => 'GLS entrega com boa etiqueta e endereço errado']);
    }
}
