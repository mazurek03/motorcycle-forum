<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\Test;

class MotoForumFinalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function strona_glowna_dziala()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    #[Test]
    public function gosc_nie_moze_wejsc_do_dashboardu()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    #[Test]
    public function przyciski_wcag_sa_obecne()
    {
        $response = $this->get('/');
        $response->assertSee('KONTRAST');
    }

    #[Test]
    public function uzytkownik_moze_sie_zalogowac()
    {
        Artisan::call('db:seed');

        $user = User::factory()->create(['role_id' => 3]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }

    #[Test]
    public function rejestracja_uzytkownika_dziala()
    {
        Artisan::call('db:seed');
        
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test_nowy@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
    }
}