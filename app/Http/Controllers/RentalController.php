<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\RentalResource;
use OpenApi\Attributes as OA;

class RentalController extends Controller
{
    
    #[OA\Get(
    path: "/api/users/{userId}/rentals",
    summary: "Liste des locations d'un utilisateur",
    tags: ["Locations"],
    parameters: [
        new OA\Parameter(
            name: "userId",
            description: "Identifiant de l'utilisateur",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Liste des locations récupérée avec succès"
        ),
        new OA\Response(
            response: 404,
            description: "Utilisateur introuvable"
        )
    ]
)]
      public function index($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur introuvable'
            ], 404);
        }

        $rentals = $user->rentals;

        return RentalResource::collection($rentals)
    ->response()
    ->setStatusCode(200);
    }
}
