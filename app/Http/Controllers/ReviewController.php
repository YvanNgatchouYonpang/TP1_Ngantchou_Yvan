<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use OpenApi\Attributes as OA;

class ReviewController extends Controller
{
    #[OA\Delete(
    path: "/api/reviews/{id}",
    summary: "Supprimer un avis",
    tags: ["Avis"],
    parameters: [
        new OA\Parameter(
            name: "id",
            description: "Identifiant de l'avis à supprimer",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(
            response: 204,
            description: "Avis supprimé avec succès"
        ),
        new OA\Response(
            response: 404,
            description: "Avis introuvable"
        )
    ]
)]
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Avis introuvable'
            ], 404);
        }

        $review->delete();

        return response()->noContent();
    }
}
