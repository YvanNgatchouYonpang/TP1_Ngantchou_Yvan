<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Equipment;

class EquipmentListTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_equipment_returns_200(): void
    {
        $response = $this->getJson('/api/equipment');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_get_equipment_returns_20_items_per_page(): void
{
    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    for ($i = 1; $i <= 25; $i++) {
        Equipment::create([
            'name' => 'Équipement ' . $i,
            'description' => 'Équipement utilisé pour le test',
            'dailyPrice' => 25,
            'categoryId' => $category->id
        ]);
    }

    $response = $this->getJson('/api/equipment');

    $response->assertStatus(200)
        ->assertJsonCount(20, 'data')
        ->assertJsonPath('meta.total', 25)
        ->assertJsonPath('meta.per_page', 20);
}
public function test_get_equipment_returns_remaining_items_on_second_page(): void
{
    $category = Category::create([
        'name' => 'Catégorie de test'
    ]);

    for ($i = 1; $i <= 25; $i++) {
        Equipment::create([
            'name' => 'Équipement ' . $i,
            'description' => 'Équipement utilisé pour le test',
            'dailyPrice' => 25,
            'categoryId' => $category->id
        ]);
    }

    $response = $this->getJson('/api/equipment?page=2');

    $response->assertStatus(200)
        ->assertJsonCount(5, 'data')
        ->assertJsonPath('meta.current_page', 2)
        ->assertJsonPath('meta.total', 25);
}
public function test_get_equipment_returns_empty_list(): void
{
    $response = $this->getJson('/api/equipment');

    $response->assertStatus(200)
        ->assertJsonCount(0, 'data')
        ->assertJsonPath('meta.total', 0);
}

}
