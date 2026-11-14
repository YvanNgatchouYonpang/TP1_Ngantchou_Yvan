<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Http\Resources\EquipmentResource;
use OpenApi\Attributes as OA;

class EquipmentController extends Controller
{
    #[OA\Get(
    path: "/api/equipment",
    summary: "Liste paginée des équipements",
    tags: ["Équipements"],
    responses: [
        new OA\Response(
            response: 200,
            description: "Liste des équipements récupérée avec succès"
        )
    ]
)]

     public function index()
    {
        $equipment = Equipment::paginate(20);
 return EquipmentResource::collection($equipment)
            ->response()
            ->setStatusCode(200);
    }


    #[OA\Get(
    path: "/api/equipment/{id}/popularity",
    summary: "Calcul de la popularité d'un équipement",
    tags: ["Équipements"],
    parameters: [
        new OA\Parameter(
            name: "id",
            description: "Identifiant de l'équipement",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Score de popularité calculé avec succès"
        ),
        new OA\Response(
            response: 404,
            description: "Équipement introuvable"
        )
    ]
)]

public function popularity($id)
{
    // Rechercher l'équipement
    $equipment = Equipment::find($id);

    // Vérifier si l'équipement existe
    if (!$equipment) {
        return response()->json([
            'message' => 'Équipement introuvable'
        ], 404);
    }

    // Compter le nombre de locations
    $rentalCount = $equipment->rentals()->count();

    // Initialiser les variables pour les notes
    $totalNotes = 0;
    $nombreNotes = 0;
    $averageRating = 0;

    // Récupérer les locations et leurs avis
    $rentals = $equipment->rentals()->with('reviews')->get();

    foreach ($rentals as $rental) {
        foreach ($rental->reviews as $review) {
            $totalNotes = $totalNotes + $review->rating;
            $nombreNotes++;
        }
    }

    // Calculer la moyenne uniquement s'il existe des avis
    if ($nombreNotes > 0) {
        $averageRating = $totalNotes / $nombreNotes;
    }

    // Calculer le score de popularité
    $popularityScore = ($rentalCount * 0.6)
                     + ($averageRating * 0.4);

    return response()->json([
        'equipmentId' => $equipment->id,
        'popularityScore' => $popularityScore
    ], 200);
}



#[OA\Get(
    path: "/api/equipment/{id}/average-rental-price",
    summary: "Calculer le prix moyen de location d'un équipement",
    tags: ["Équipements"],
    parameters: [
        new OA\Parameter(
            name: "id",
            description: "Identifiant de l'équipement",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        ),
        new OA\Parameter(
            name: "minDate",
            description: "Date minimale de début de location (YYYY-MM-DD)",
            in: "query",
            required: false,
            schema: new OA\Schema(
                type: "string",
                format: "date"
            )
        ),
        new OA\Parameter(
            name: "maxDate",
            description: "Date maximale de fin de location (YYYY-MM-DD)",
            in: "query",
            required: false,
            schema: new OA\Schema(
                type: "string",
                format: "date"
            )
        ),
        new OA\Parameter(
            name: "maxTotalPrice",
            description: "Prix total maximal d'une location",
            in: "query",
            required: false,
            schema: new OA\Schema(
                type: "number",
                minimum: 0
            )
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Prix moyen calculé avec succès"
        ),
        new OA\Response(
            response: 404,
            description: "Équipement introuvable"
        ),
        new OA\Response(
            response: 422,
            description: "Paramètres de filtrage invalides"
        )
    ]
)]


public function averageRentalPrice(Request $request, $id)
{
    $equipment = Equipment::find($id);

    if (!$equipment) {
        return response()->json([
            'message' => 'Équipement introuvable'
        ], 404);
    }
    $validated = $request->validate([
    'minDate' => 'sometimes|required|date_format:Y-m-d',
    'maxDate' => 'sometimes|required|date_format:Y-m-d',
    'maxTotalPrice' => 'sometimes|required|numeric|min:0',
]);
if (isset($validated['minDate'], $validated['maxDate'])
    && $validated['minDate'] >= $validated['maxDate']) {

    return response()->json([
        'message' => 'minDate doit être inférieure à maxDate'
    ], 422);
}
$query = $equipment->rentals();

if (isset($validated['minDate'])) {
    $query->where('startDate', '>=', $validated['minDate']);
}

if (isset($validated['maxDate'])) {
    $query->where('endDate', '<=', $validated['maxDate']);
}

if (isset($validated['maxTotalPrice'])) {
    $query->where('totalPrice', '<=', $validated['maxTotalPrice']);
}
$averagePrice = $query->avg('totalPrice');

return response()->json([
    'equipmentId' => $equipment->id,
    'averageRentalPrice' => $averagePrice !== null
        ? round((float) $averagePrice, 2)
        : null
], 200);
}

}
