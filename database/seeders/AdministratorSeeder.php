<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Administrator
        User::create([
            'name' => 'Admin BPP',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'remember_token' => Str::random(5),
        ])->assignRole('admin')->givePermissionTo(['create', 'read', 'update', 'delete']);

        // Supervisor
        User::create([
            'name' => 'Kepla sekolah',
            'email' => 'kepsek@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('kepsek'),
            'remember_token' => Str::random(5),
        ])->assignRole('supervisor')->givePermissionTo(['create', 'read']);
    }
}
