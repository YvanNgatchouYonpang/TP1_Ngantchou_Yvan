<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_be_updated_with_valid_data(): void
    {
        $user = \App\Models\User::factory()->create();
        $updatedData = [
    'firstName' => 'Jean-Pierre',
    'lastName' => 'Tremblay',
    'email' => 'jean.pierre@example.com',
    'phone' => '4185559876',
];


       $response = $this->putJson('/api/users/' . $user->id, $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
    'id' => $user->id,
    'firstName' => 'Jean-Pierre',
    'lastName' => 'Tremblay',
    'email' => 'jean.pierre@example.com',
    'phone' => '4185559876',
]);
    }

    public function test_user_cannot_be_updated_when_not_found(): void
{
$updatedData = [
    'firstName' => 'Pierre',
    'lastName' => 'Martin',
    'email' => 'pierre.martin@example.com',
    'phone' => '4185559999',
];
$response = $this->putJson('/api/users/999999', $updatedData);
$response->assertStatus(404);
$response->assertJson([
    'message' => 'Utilisateur introuvable'
]);
}

public function test_user_cannot_be_updated_with_missing_required_field(): void
{
    $user = \App\Models\User::factory()->create();
    $updatedData = [
    'lastName' => 'Tremblay',
    'email' => 'jean.tremblay@example.com',
    'phone' => '4185551234',
];
$response = $this->putJson('/api/users/' . $user->id, $updatedData);
$response->assertStatus(422);
$response->assertJsonValidationErrors(['firstName']);

}

public function test_user_cannot_be_updated_with_invalid_email(): void
{
    $user = \App\Models\User::factory()->create();
    $updatedData = [
    'firstName' => 'Jean',
    'lastName' => 'Tremblay',
    'email' => 'email-invalide',
    'phone' => '4185551234',
];
$response = $this->putJson('/api/users/' . $user->id, $updatedData);
$response->assertStatus(422);
$response->assertJsonValidationErrors(['email']);

}

public function test_user_cannot_be_updated_with_duplicate_email(): void
{
    $user = \App\Models\User::factory()->create();
    $otherUser = \App\Models\User::factory()->create();
    $updatedData = [
    'firstName' => 'Jean',
    'lastName' => 'Tremblay',
    'email' => $otherUser->email,
    'phone' => '4185551234',
];
$response = $this->putJson('/api/users/' . $user->id, $updatedData);
$response->assertStatus(422);
$response->assertJsonValidationErrors(['email']);

}

}
