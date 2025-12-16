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
        $admin = User::factory()->create([
            'name' => 'Sam',
            'last_name' => 'Tab',
            'email' => 'sam@example.com',
            'phone_number' => '987654321',
        ]);
        $admin->assignRole('super_admin');
        
        // Create addresses for admin
        $admin->addresses()->create([
            'department' => 'Lima',
            'province' => 'Lima',
            'district' => 'Miraflores',
            'address' => 'Av. Larco 1234',
            'reference' => 'Cerca del parque Kennedy',
            'address_type' => 'home',
            'is_default' => true,
        ]);
        
        $admin->addresses()->create([
            'department' => 'Lima',
            'province' => 'Lima',
            'district' => 'San Isidro',
            'address' => 'Av. Javier Prado 567',
            'reference' => 'Edificio azul',
            'address_type' => 'work',
            'is_default' => false,
        ]);

        $user = User::factory()->create([
            'name' => 'User',
            'last_name' => 'Test',
            'email' => 'user@example.com',
            'phone_number' => '912345678',
        ]);
        $user->assignRole('user');
        
        // Create address for regular user
        $user->addresses()->create([
            'department' => 'Lima',
            'province' => 'Lima',
            'district' => 'Surco',
            'address' => 'Jr. Las Camelias 890',
            'reference' => 'Frente al parque',
            'address_type' => 'home',
            'is_default' => true,
        ]);
    }
}
