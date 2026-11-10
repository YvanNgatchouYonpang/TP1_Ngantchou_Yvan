<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
       use RefreshDatabase;

    /**
     * A basic feature test example.
     */
   public function test_database_seeder_creates_data(): void
{
    $this->seed();

    $this->assertDatabaseCount('sports', 5);
    $this->assertDatabaseCount('categories', 4);
    $this->assertDatabaseCount('equipment', 5);
    $this->assertDatabaseCount('equipment_sport', 7);

    $this->assertDatabaseCount('users', 10);
    $this->assertDatabaseCount('rentals', 10);
    $this->assertDatabaseCount('reviews', 10);
    $this->assertDatabaseCount('config', 1);
}
}
