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
            'data' => PersonResource::collection(Person::with('relations')->get()),
        ]);
    }

    public function get(int $id): JsonResponse
    {
        $person = Person::with('relations')->find($id);

        return response()->json([
            'success' => !!$person,
            'data' => $person ?: null,
        ]);
    }

    public function getTree(int $id)
    {
        //
    }

    public function create(CreatePersonRequest $request): JsonResponse
    {
        $person = Person::createPerson($request->all());

        Notification::route('slack', env('SLACK_INCOMING_WEBHOOK_URI'))
            ->notify(new PersonCreatedNotification($person, '@Ezekiel'));

        return response()->json([
            'success' => true,
            'data' => new PersonResource($person),
        ]);
    }

    public function update(CreatePersonRequest $request, int $id)
    {
        //
    }

    public function add(Request $request, int $id)
    {
        //
    }

    public function remove(int $id)
    {
        Person::find($id)->delete();

        return response()->json([
            'success' => true,
            'data' => null,
        ]);
    }
}
