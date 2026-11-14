<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Rental;

class UserRentalsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_rentals_returns_404_when_user_not_found(): void
    {
        $response = $this->getJson('/api/users/999999/rentals');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Utilisateur introuvable'
            ]);
    }

    public function test_get_rentals_returns_empty_list_when_user_has_no_rentals(): void
{
    $user = User::factory()->create();

    $response = $this->getJson(
        "/api/users/{$user->id}/rentals"
    );

    $response->assertStatus(200)
        ->assertJsonCount(0, 'data');
}

public function test_get_rentals_returns_user_rentals(): void
{
    // Créer un utilisateur
    $user = User::factory()->create();

    // Créer une catégorie
    $category = Category::create([
        'name' => 'Sports',
    ]);

    // Créer un équipement
    $equipment = Equipment::create([
        'name' => 'Ballon de football',
        'description' => 'Ballon pour les entraînements',
        'dailyPrice' => 10,
        'categoryId' => $category->id,
    ]);

    // Créer une location associée à cet utilisateur
    $rental = Rental::create([
        'startDate' => '2026-11-01',
        'endDate' => '2026-11-03',
        'totalPrice' => 30,
        'userId' => $user->id,
        'equipmentId' => $equipment->id,
    ]);

    // Envoyer la requête GET
    $response = $this->getJson("/api/users/{$user->id}/rentals");

    // Vérifier la réponse
    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $rental->id)
        ->assertJsonPath('data.0.userId', $user->id)
        ->assertJsonPath('data.0.equipmentId', $equipment->id);
}
}
