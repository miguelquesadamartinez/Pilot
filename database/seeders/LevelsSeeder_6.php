<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use App\Models\tickets_level_a;
use App\Models\tickets_level_b;
use App\Models\tickets_level_c;
use Illuminate\Database\Seeder;
use App\Models\TicketCategories;
use Illuminate\Support\Facades\DB;


class LevelsSeeder_6 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tickets_level_a::find(11)->delete();
    }
}
