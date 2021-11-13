<?php

use App\Models\Person;
use App\Notifications\PersonCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

/**
 * GET "/api/people"
 */
it('can list the people available in the database', function () {
    $this->getJson('/api/people')
        ->assertStatus(200)
        ->assertJson(['success' => true, 'message' => 'List of all people']);
});

/**
 * GET "/api/people/{person}"
 */
it('can get the details of a single family member', function () {
    $people = Person::factory(2)->create();

    $this->getJson("/api/people/{$people[0]->id}")
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data']);
});

/**
 * POST "/api/people/create"
 */
it('can create a person and send a Slack notification', function () {
    Notification::fake();

    $this->postJson('/api/people/create', [
        'first_name' => 'Ezekiel',
        'last_name' => 'Oladejo',
    ])->assertStatus(200)->assertJson([
        'success' => true,
        'message' => 'New family member has been created.',
    ]);

    Notification::assertSentTo(new AnonymousNotifiable(), PersonCreatedNotification::class);

    $this->assertDatabaseCount('people', 1);
});

/**
 * PUT "/api/people/{person}/update"
 */
it('can update the details of a person', function () {
    Person::factory(5)->create();

    $response = $this->putJson('/api/people/1/update', [
        'first_name' => 'Ezekiel',
        'last_name' => 'Oladejo',
    ])->assertStatus(200)->assertJsonStructure(['success', 'message', 'data']);

    $response = json_decode($response->getContent());

    expect($response->data->first_name)->toBe('Ezekiel');
    expect($response->message)->toBe('Family member has been updated.');

    $this->assertDatabaseHas('people', [
        'first_name' => 'Ezekiel',
        'last_name' => 'Oladejo',
    ]);
});
