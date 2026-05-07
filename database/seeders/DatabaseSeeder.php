<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\TechnicianProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Categories
        $categories = [
            ['name' => 'Éclairage', 'icon' => '💡'],
            ['name' => 'Routes', 'icon' => '🛣️'],
            ['name' => 'Déchets', 'icon' => '🗑️'],
            ['name' => 'Eau', 'icon' => '🚰'],
            ['name' => 'Trafic', 'icon' => '🚦'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Admin
        User::create([
            'name' => 'Admin SmartCity',
            'email' => 'admin@smartcity.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Technician 1
        $tech1 = User::create([
            'name' => 'Technicien Éclairage',
            'email' => 'tech1@smartcity.com',
            'password' => Hash::make('password123'),
            'role' => 'technician',
        ]);
        TechnicianProfile::create([
            'user_id' => $tech1->id,
            'speciality' => 'Éclairage Public',
            'city' => 'Casablanca',
            'phone' => '0612345678',
            'is_available' => true,
            'rating' => 4.8,
        ]);

        // Technician 2
        $tech2 = User::create([
            'name' => 'Technicien Voirie',
            'email' => 'tech2@smartcity.com',
            'password' => Hash::make('password123'),
            'role' => 'technician',
        ]);
        TechnicianProfile::create([
            'user_id' => $tech2->id,
            'speciality' => 'Routes et Chaussées',
            'city' => 'Casablanca',
            'phone' => '0687654321',
            'is_available' => true,
            'rating' => 4.5,
        ]);

        // Citizen
        User::create([
            'name' => 'Citoyen Engagé',
            'email' => 'citizen@smartcity.com',
            'password' => Hash::make('password123'),
            'role' => 'citizen',
        ]);
    }
}
