<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'phone' => 'required|string|max:12',
        ]);

        $user = User::create($validated);

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user' => $user
        ], 201);
    }

    public function update(Request $request, $id)
{
    $user = User::find($id);
    if (!$user) {
    return response()->json([
        'message' => 'Utilisateur introuvable'
    ], 404);
}
$validated = $request->validate([
    'firstName' => 'required|string|max:50',
    'lastName' => 'required|string|max:50',
    'email' => 'required|email|max:50|unique:users,email,' . $id,
    'phone' => 'required|string|max:12',
]);
$user->update($validated);
return response()->json([
    'message' => 'Utilisateur mis à jour avec succès',
    'user' => $user
], 200);

}
}
