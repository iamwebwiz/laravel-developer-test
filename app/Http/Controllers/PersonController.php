<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePersonRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use App\Notifications\PersonCreatedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PersonController extends Controller
{
    public function list(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => PersonResource::collection(Person::with('relation')->get()),
        ]);
    }

    public function get(int $id): JsonResponse
    {
        $person = Person::with('relation')->find($id);

        return response()->json([
            'success' => !!$person,
            'data' => $person ?: null,
        ]);
    }

    public function create(CreatePersonRequest $request): JsonResponse
    {
        $person = Person::createPerson($request->all());

        Notification::route('slack', env('SLACK_INCOMING_WEBHOOK_URI'))
            ->notify(new PersonCreatedNotification($person));

        return response()->json([
            'success' => true,
            'data' => $person,
        ]);
    }
}
