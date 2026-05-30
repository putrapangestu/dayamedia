<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();

        foreach ($roles as $role) {
            $user = User::create([
                'full_name' => $role->name,
                'email' => $role->name.'@dayamedia.id',
                'password' => bcrypt('password'),
            ]);

            $user->assignRole($role->name);
        }

        $usr = User::create([
            'full_name' => 'user',
            'email' => 'user@dayamedia.id',
            'password' => bcrypt('password'),
        ]);

        $usr->assignRole('member');
    }
}
