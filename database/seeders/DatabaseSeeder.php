<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    // Tworzymy 3 podstawowe role
    \App\Models\Role::create(['name' => 'admin']);
    \App\Models\Role::create(['name' => 'worker']);
    \App\Models\Role::create(['name' => 'client']);

    // Tworzymy przykładowe kategorie forum
    \App\Models\Category::create(['name' => 'Warsztat']);
    \App\Models\Category::create(['name' => 'Zloty i imprezy']);
}
}
