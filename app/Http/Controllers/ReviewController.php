<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
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
