<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Post(
    path: "/api/users",
    summary: "Créer un utilisateur",
    tags: ["Utilisateurs"],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["firstName", "lastName", "email", "phone"],
            properties: [
                new OA\Property(
                    property: "firstName",
                    type: "string",
                    maxLength: 50,
                    example: "Jean"
                ),
                new OA\Property(
                    property: "lastName",
                    type: "string",
                    maxLength: 50,
                    example: "Dupont"
                ),
                new OA\Property(
                    property: "email",
                    type: "string",
                    format: "email",
                    maxLength: 50,
                    example: "jean.dupont@example.com"
                ),
                new OA\Property(
                    property: "phone",
                    type: "string",
                    maxLength: 12,
                    example: "4185551234"
                )
            ]
        )
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: "Utilisateur créé avec succès"
        ),
        new OA\Response(
            response: 422,
            description: "Erreur de validation des données"
        )
    ]
)]
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

    #[OA\Put(
    path: "/api/users/{id}",
    summary: "Modifier un utilisateur",
    tags: ["Utilisateurs"],
    parameters: [
        new OA\Parameter(
            name: "id",
            description: "Identifiant de l'utilisateur",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["firstName", "lastName", "email", "phone"],
            properties: [
                new OA\Property(
                    property: "firstName",
                    type: "string",
                    maxLength: 50,
                    example: "Jean"
                ),
                new OA\Property(
                    property: "lastName",
                    type: "string",
                    maxLength: 50,
                    example: "Martin"
                ),
                new OA\Property(
                    property: "email",
                    type: "string",
                    format: "email",
                    maxLength: 50,
                    example: "jean.martin@example.com"
                ),
                new OA\Property(
                    property: "phone",
                    type: "string",
                    maxLength: 12,
                    example: "4185555678"
                )
            ]
        )
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: "Utilisateur mis à jour avec succès"
        ),
        new OA\Response(
            response: 404,
            description: "Utilisateur introuvable"
        ),
        new OA\Response(
            response: 422,
            description: "Erreur de validation des données"
        )
    ]
)]
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
