<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $super_admin = User::factory()->create([
            'name' => 'Sam',
            'last_name' => 'Tab',
            'email' => 'sam@example.com',
            'phone_number' => '987654321',
        ]);
        $super_admin->assignRole('super_admin');
        $super_admin->addresses()->create([
            'department' => 'Lima',
            'province' => 'Lima',
            'district' => 'Miraflores',
            'address' => 'Av. Larco 1234',
            'reference' => 'Cerca del parque Kennedy',
            'address_type' => 'home',
            'is_default' => true,
        ]);

        // Admin
        $admin = User::factory()->create([
            'name' => 'Admin',
            'last_name' => 'Owner',
            'email' => 'admin@example.com',
            'phone_number' => '987444333',
        ]);
        $admin->assignRole('admin');        
        $admin->addresses()->create([
            'department' => 'Lima',
            'province' => 'Lima',
            'district' => 'Lima',
            'address' => 'Av. Lima 123',
            'reference' => 'Cerca del parque A',
            'address_type' => 'home',
            'is_default' => true,
        ]);

        // Users
        User::factory(8)->create()->each(function ($user) {
            $user->assignRole('user');
            $user->addresses()->create([
                'department' => 'Lima',
                'province' => 'Lima',
                'district' => 'Surco',
                'address' => 'Jr. Las Camelias 890',
                'reference' => 'Frente al parque B',
                'address_type' => 'home',
                'is_default' => true,
            ]);
        });
    }
}