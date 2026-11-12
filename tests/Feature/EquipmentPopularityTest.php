<?php

namespace Tests\Feature;
use App\Models\Equipment;
use App\Models\Rental;
use App\Models\Review;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EquipmentPopularityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_equipment_popularity_score_with_reviews(): void
    {
        $this->seed();

        $equipment = Equipment::create([
    'name' => 'Équipement de test',
    'description' => 'Équipement utilisé pour tester le score de popularité',
    'dailyPrice' => 25.00,
    'categoryId' => 1,
]);
$rental1 = Rental::create([
    'startDate' => '2026-11-01',
    'endDate' => '2026-11-03',
    'totalPrice' => 75.00,
    'userId' => 1,
    'equipmentId' => $equipment->id,
]);
$rental2 = Rental::create([
    'startDate' => '2026-11-04',
    'endDate' => '2026-11-06',
    'totalPrice' => 75.00,
    'userId' => 2,
    'equipmentId' => $equipment->id,
]);
$rental3 = Rental::create([
    'startDate' => '2026-11-07',
    'endDate' => '2026-11-09',
    'totalPrice' => 75.00,
    'userId' => 3,
    'equipmentId' => $equipment->id,
]);
Review::create([
    'rating' => 4,
    'comment' => 'Très bon équipement',
    'userId' => 1,
    'rentalId' => $rental1->id,
]);
Review::create([
    'rating' => 5,
    'comment' => 'Excellent équipement',
    'userId' => 2,
    'rentalId' => $rental2->id,
]);
       $response = $this->getJson('/api/equipment/' . $equipment->id . '/popularity');

        $response->assertStatus(200);
        $response->assertJsonPath('equipmentId', $equipment->id);
       $this->assertEqualsWithDelta(
    3.6,
    $response->json('popularityScore'),
    0.0001
);
    }
}
