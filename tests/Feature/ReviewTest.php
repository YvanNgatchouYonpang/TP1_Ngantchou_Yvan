<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Rental;
use App\Models\Review;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_review_returns_404_when_not_found(): void
    {
        $response = $this->deleteJson('/api/reviews/999999');

        $response->assertStatus(404);

        $response->assertJson([
            'message' => 'Avis introuvable'
        ]);
    }

    public function test_delete_existing_review_returns_204(): void
    {
        // 1. Créer un utilisateur
        $user = User::factory()->create();

        // 2. Créer une catégorie
        $category = Category::create([
            'name' => 'Catégorie de test',
        ]);

        // 3. Créer un équipement
        $equipment = Equipment::create([
            'name' => 'Équipement de test',
            'description' => 'Équipement utilisé pour le test',
            'dailyPrice' => 25.00,
            'categoryId' => $category->id,
        ]);

        // 4. Créer une location
        $rental = Rental::factory()->create([
            'userId' => $user->id,
            'equipmentId' => $equipment->id,
        ]);

        // 5. Créer un avis
        $review = Review::factory()->create([
            'userId' => $user->id,
            'rentalId' => $rental->id,
        ]);

        // 6. Supprimer l'avis
        $response = $this->deleteJson('/api/reviews/' . $review->id);

        // 7. Vérifier le statut HTTP
        $response->assertStatus(204);

        // 8. Vérifier que l'avis n'existe plus
        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }
}
