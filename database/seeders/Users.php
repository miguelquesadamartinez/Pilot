<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'name' => 'Miguel Quesada Martinez',
            'email' => 'm.quesada@callmedicall.com',
            'password' => bcrypt('Anna@1804'),
            'language' => 'es',
            'samaccountname' => 'm.quesada',
        ]);

        DB::table('users')->insert([
            'name' => 'none',
            'email' => 'none@callmedicall.com',
            'password' => bcrypt('123456789'),
            'language' => 'fr',
            'samaccountname' => 'g.naze',
        ]);


        $user = User::find(1);

        $user->assignRole(1);

        $user = User::find(2);

        $user->assignRole(1);


    }
}
