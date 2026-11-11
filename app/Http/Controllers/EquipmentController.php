<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Http\Resources\EquipmentResource;

class EquipmentController extends Controller
{
    //
     public function index()
    {
        $equipment = Equipment::paginate(20);
 return EquipmentResource::collection($equipment)
            ->response()
            ->setStatusCode(200);
    }


    /**
 * Calcule le score de popularité d'un équipement.
 *
 * Formule : (nombre de locations * 0.6) + (moyenne des notes * 0.4).
 *
 * Sources :
 * - Énoncé du TP1 : formule de calcul du score de popularité.
 * - OpenAI, ChatGPT : assistance à l'implémentation de la méthode
 *   avec Laravel Eloquent (count, with, flatMap, pluck et avg).
 *
 * https://chatgpt.com/
 */
    public function popularity($id)
{
    $equipment = Equipment::find($id);

    if (!$equipment) {
        return response()->json([
            'message' => 'Équipement introuvable'
        ], 404);
    }

    $rentalCount = $equipment->rentals()->count();

    $ratings = $equipment->rentals()
        ->with('reviews')
        ->get()
        ->flatMap(function ($rental) {
            return $rental->reviews->pluck('rating');
        });

    $averageRating = $ratings->avg() ?? 0;

    $popularityScore = ($rentalCount * 0.6) + ($averageRating * 0.4);

    return response()->json([
        'equipmentId' => $equipment->id,
        'popularityScore' => $popularityScore
    ], 200);
}
}
