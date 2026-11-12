<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCreationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_be_created_with_valid_data(): void
    {
        $userData = [
    'firstName' => 'Marie',
    'lastName' => 'Tremblay',
    'email' => 'marie.tremblay@example.com',
    'phone' => '4185555678',
];
       $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
    'firstName' => 'Marie',
    'lastName' => 'Tremblay',
    'email' => 'marie.tremblay@example.com',
    'phone' => '4185555678',
]);
    }

    public function test_user_cannot_be_created_with_invalid_email(): void
{
    $userData = [
    'firstName' => 'Pierre',
    'lastName' => 'Martin',
    'email' => 'adresse-invalide',
    'phone' => '4185559999',
];
$response = $this->postJson('/api/users', $userData);
$response->assertStatus(422);
$response->assertJsonValidationErrors(['email']);

}

public function test_user_cannot_be_created_with_duplicate_email(): void
{
\App\Models\User::factory()->create([
    'email' => 'pierre.martin@example.com',
]);
$userData = [
    'firstName' => 'Jean',
    'lastName' => 'Dupont',
    'email' => 'pierre.martin@example.com',
    'phone' => '4185551234',
];
$response = $this->postJson('/api/users', $userData);
$response->assertStatus(422);
$response->assertJsonValidationErrors(['email']);
}
}
