<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'members-rel-rep']);

        $admins = [
            [
                'first_name' => 'Gabriel',
                'last_name' => 'Medina',
                'email' => 'gabi89.m@gmail.com',
                'country_code' => 'AR',
                'password' => Hash::make('12345678'),
            ],
            [
                'first_name' => 'Chris',
                'last_name' => 'Laroue',
                'email' => 'chrislaroue19@gmail.com',
                'country_code' => 'US',
                'password' => Hash::make('Poncho65!'),
            ],
        ];

        foreach ($admins as $admin) {
            $user = User::create($admin);
            $adminRole = Role::query()->where('name', '=', 'admin')->first();
            $user->syncRoles($adminRole);
        }
    }
}
