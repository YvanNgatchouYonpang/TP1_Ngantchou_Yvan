<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AverageRentalPriceTest extends TestCase
{
    use RefreshDatabase;
    public function test_average_rental_price_without_filters(): void
{
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    $equipment = Equipment::create([
        'name' => 'Équipement de test',
        'description' => 'Équipement utilisé pour les tests',
        'dailyPrice' => 25,
        'categoryId' => $category->id
    ]);

    Rental::create([
        'startDate' => '2026-01-01',
        'endDate' => '2026-01-03',
        'totalPrice' => 100,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-02-01',
        'endDate' => '2026-02-05',
        'totalPrice' => 200,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-03-01',
        'endDate' => '2026-03-07',
        'totalPrice' => 300,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    $response = $this->getJson(
        "/api/equipment/{$equipment->id}/average-rental-price"
    );

    $response->assertStatus(200)
        ->assertJson([
            'equipmentId' => $equipment->id,
            'averageRentalPrice' => 200
        ]);
}
public function test_average_rental_price_with_min_date(): void
{
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    $equipment = Equipment::create([
        'name' => 'Équipement de test',
        'description' => 'Équipement utilisé pour les tests',
        'dailyPrice' => 25,
        'categoryId' => $category->id
    ]);

    Rental::create([
        'startDate' => '2026-01-01',
        'endDate' => '2026-01-03',
        'totalPrice' => 100,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-02-01',
        'endDate' => '2026-02-05',
        'totalPrice' => 200,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-03-01',
        'endDate' => '2026-03-07',
        'totalPrice' => 300,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    $response = $this->getJson(
        "/api/equipment/{$equipment->id}/average-rental-price?minDate=2026-02-01"
    );

    $response->assertStatus(200)
        ->assertJson([
            'equipmentId' => $equipment->id,
            'averageRentalPrice' => 250
        ]);
}
public function test_average_rental_price_with_max_date(): void
{
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    $equipment = Equipment::create([
        'name' => 'Équipement de test',
        'description' => 'Équipement utilisé pour les tests',
        'dailyPrice' => 25,
        'categoryId' => $category->id
    ]);

    Rental::create([
        'startDate' => '2026-01-01',
        'endDate' => '2026-01-03',
        'totalPrice' => 100,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-02-01',
        'endDate' => '2026-02-05',
        'totalPrice' => 200,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-03-01',
        'endDate' => '2026-03-07',
        'totalPrice' => 300,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    $response = $this->getJson(
        "/api/equipment/{$equipment->id}/average-rental-price?maxDate=2026-02-05"
    );

    $response->assertStatus(200)
        ->assertJson([
            'equipmentId' => $equipment->id,
            'averageRentalPrice' => 150
        ]);
}
public function test_average_rental_price_with_max_total_price(): void
{
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    $equipment = Equipment::create([
        'name' => 'Équipement de test',
        'description' => 'Équipement utilisé pour les tests',
        'dailyPrice' => 25,
        'categoryId' => $category->id
    ]);

    Rental::create([
        'startDate' => '2026-01-01',
        'endDate' => '2026-01-03',
        'totalPrice' => 100,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-02-01',
        'endDate' => '2026-02-05',
        'totalPrice' => 200,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-03-01',
        'endDate' => '2026-03-07',
        'totalPrice' => 300,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    $response = $this->getJson(
        "/api/equipment/{$equipment->id}/average-rental-price?maxTotalPrice=200"
    );

    $response->assertStatus(200)
        ->assertJson([
            'equipmentId' => $equipment->id,
            'averageRentalPrice' => 150
        ]);
}
public function test_average_rental_price_with_all_filters(): void
{
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    $equipment = Equipment::create([
        'name' => 'Équipement de test',
        'description' => 'Équipement utilisé pour les tests',
        'dailyPrice' => 25,
        'categoryId' => $category->id
    ]);

    Rental::create([
        'startDate' => '2026-01-01',
        'endDate' => '2026-01-03',
        'totalPrice' => 100,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-02-01',
        'endDate' => '2026-02-05',
        'totalPrice' => 200,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    Rental::create([
        'startDate' => '2026-03-01',
        'endDate' => '2026-03-07',
        'totalPrice' => 300,
        'userId' => $user->id,
        'equipmentId' => $equipment->id
    ]);

    $response = $this->getJson(
        "/api/equipment/{$equipment->id}/average-rental-price"
        . "?minDate=2026-02-01&maxDate=2026-03-07&maxTotalPrice=250"
    );

    $response->assertStatus(200)
        ->assertJson([
            'equipmentId' => $equipment->id,
            'averageRentalPrice' => 200
        ]);
}
public function test_average_rental_price_rejects_invalid_date_order(): void
{
    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    $equipment = Equipment::create([
        'name' => 'Équipement de test',
        'description' => 'Équipement utilisé pour les tests',
        'dailyPrice' => 25,
        'categoryId' => $category->id
    ]);

    $response = $this->getJson(
        "/api/equipment/{$equipment->id}/average-rental-price"
        . "?minDate=2026-08-01&maxDate=2026-06-30"
    );

    $response->assertStatus(422)
        ->assertJson([
            'message' => 'minDate doit être inférieure à maxDate'
        ]);
}
public function test_average_rental_price_rejects_invalid_date_format(): void
{
    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    $equipment = Equipment::create([
        'name' => 'Équipement de test',
        'description' => 'Équipement utilisé pour les tests',
        'dailyPrice' => 25,
        'categoryId' => $category->id
    ]);

    $response = $this->getJson(
        "/api/equipment/{$equipment->id}/average-rental-price"
        . "?minDate=12-06-2026"
    );

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['minDate']);
}
public function test_average_rental_price_returns_404_when_equipment_not_found(): void
{
    $response = $this->getJson(
        '/api/equipment/999999/average-rental-price'
    );

    $response->assertStatus(404)
        ->assertJson([
            'message' => 'Équipement introuvable'
        ]);
}
public function test_average_rental_price_returns_null_when_no_rentals(): void
{
    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    $equipment = Equipment::create([
        'name' => 'Équipement de test',
        'description' => 'Équipement utilisé pour les tests',
        'dailyPrice' => 25,
        'categoryId' => $category->id
    ]);

    $response = $this->getJson(
        "/api/equipment/{$equipment->id}/average-rental-price"
    );

    $response->assertStatus(200)
        ->assertJson([
            'equipmentId' => $equipment->id,
            'averageRentalPrice' => null
        ]);
}
public function test_average_rental_price_rejects_negative_max_total_price(): void
{
    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    $equipment = Equipment::create([
        'name' => 'Équipement de test',
        'description' => 'Équipement utilisé pour les tests',
        'dailyPrice' => 25,
        'categoryId' => $category->id
    ]);

    $response = $this->getJson(
        "/api/equipment/{$equipment->id}/average-rental-price"
        . "?maxTotalPrice=-100"
    );

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['maxTotalPrice']);
}
}
