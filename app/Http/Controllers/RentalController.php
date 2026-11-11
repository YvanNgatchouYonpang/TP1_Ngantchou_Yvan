<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\RentalResource;

class RentalController extends Controller
{
    //
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
