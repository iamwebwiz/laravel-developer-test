<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\JsonResponse;

class PersonController extends Controller
{
    public function list(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => PersonResource::collection(Person::all()),
        ]);
    }
}
