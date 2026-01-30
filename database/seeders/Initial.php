<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Initial extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::create(['name' => 'Manage']);

        $admin_role = Role::create(['name' => 'Admin']);
        $admin_role->givePermissionTo('Manage');

        DB::table('users')->insert([
            'name' => 'Miguel Quesada Martinez',
            'email' => 'm.quesada@callmedicall.com',
            'password' => bcrypt('Anna@1804'),
            'language' => 'es',
        ]);

        DB::table('users')->insert([
            'name' => 'none',
            'email' => 'none@callmedicall.com',
            'password' => bcrypt('123456789'),
            'language' => 'fr',
        ]);

        $order_role = Role::create(['name' => 'OrderController']);
        $searcher_role = Role::create(['name' => 'Searcher']);
        $data_role = Role::create(['name' => 'DataLoader']);
        $ticket_role = Role::create(['name' => 'Ticketing']);
        $user_role = Role::create(['name' => 'Users']);
        $file_role = Role::create(['name' => 'FileGenerator']);

        $user = User::find(1);

        $user->assignRole($admin_role);
        $user->assignRole($order_role);
        $user->assignRole($searcher_role);
        $user->assignRole($data_role);
        $user->assignRole($ticket_role);
        $user->assignRole($user_role);
        $user->assignRole($file_role);

        $user = User::find(2);

        $user->assignRole($admin_role);
        $user->assignRole($order_role);
        $user->assignRole($searcher_role);
        $user->assignRole($data_role);
        $user->assignRole($ticket_role);
        $user->assignRole($user_role);
        $user->assignRole($file_role);

    }
}
