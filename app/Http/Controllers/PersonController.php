<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectPeopleRequest;
use App\Http\Requests\CreatePersonRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use App\Notifications\PersonCreatedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class PersonController extends Controller
{
    public function list(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'List of all people',
            'data' => PersonResource::collection(Person::with('relations')->get()),
        ]);
    }

    public function get(int $id): JsonResponse
    {
        $person = Person::with('relations')->find($id);

        return response()->json([
            'success' => !!$person,
            'message' => 'Family member details fetched.',
            'data' => new PersonResource($person) ?: null,
        ]);
    }

    public function getTree(int $id)
    {
        $person = Person::find($id);

        return response()->json([
            'success' => true,
            'message' => sprintf('Family tree for [%s] fetched', $person->fullName),
            'data' => $person->buildFamilyTree(),
        ]);
    }

    public function create(CreatePersonRequest $request): JsonResponse
    {
        $person = Person::createPerson($request->all());

        Notification::route('slack', env('SLACK_INCOMING_WEBHOOK_URI'))
            ->notify(new PersonCreatedNotification($person, '@Ezekiel'));

        return response()->json([
            'success' => true,
            'message' => 'New family member has been created.',
            'data' => new PersonResource($person),
        ]);
    }

    public function update(CreatePersonRequest $request, int $id): JsonResponse
    {
        $person = Person::find($id);
        $person->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Family member has been updated.',
            'data' => $person,
        ]);
    }

    public function add(ConnectPeopleRequest $request, int $id): JsonResponse
    {
        $person = Person::find($id);

        $person->connectRelationToPerson($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Relations have been added to family member.',
            'data' => new PersonResource($person),
        ]);
    }

    public function remove(int $id): JsonResponse
    {
        Person::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully removed family member.',
            'data' => null,
        ]);
    }
}
