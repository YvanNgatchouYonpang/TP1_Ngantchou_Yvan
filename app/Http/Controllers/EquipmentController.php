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
}
