<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Czyszczenie starych danych (opcjonalnie, dla pewności)
        // Role::truncate(); 

        // 2. Tworzymy role
        $adminRole = Role::create(['name' => 'admin']);
        $workerRole = Role::create(['name' => 'worker']);
        $clientRole = Role::create(['name' => 'client']);

        // 3. Tworzymy przykładowe kategorie
        Category::create(['name' => 'Warsztat']);
        Category::create(['name' => 'Zloty i imprezy']);

        // 4. Tworzymy konto ADMINISTRATORA
        User::create([
            'name' => 'Admin Michal',
            'email' => 'admin@wp.pl',
            'email_verified_at' => now(),
            'password' => Hash::make('admin!123'),
            'role_id' => 1, // Zakładamy, że admin to ID 1
            'remember_token' => Str::random(10),
        ]);

        // 5. Tworzymy 5 przykładowych użytkowników ręcznie (zamiast factory)
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Uzytkownik $i",
                'email' => "user$i@wp.pl",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role_id' => 3, // Klient
                'remember_token' => Str::random(10),
            ]);
        }

        $this->command->info('SUKCES: Utworzono role, kategorie, admina i 5 uzytkownikow!');
    }
}