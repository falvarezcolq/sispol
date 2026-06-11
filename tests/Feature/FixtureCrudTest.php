<?php

use App\Models\Fixture;
use App\Models\Country;
use App\Models\Group;
use App\Models\User;

test('authenticated users can visit fixtures index', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('fixtures.index'));

    $response->assertOk();
});

test('users can create fixtures', function () {
    $user = User::factory()->create();
    $country1 = Country::factory()->create();
    $country2 = Country::factory()->create();
    $group = Group::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('fixtures.store'), [
            'country_id_1' => $country1->id,
            'country_id_2' => $country2->id,
            'group_id' => $group->id,
            'match_date' => '2026-06-11 20:00',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('fixtures.index'));

    $this->assertDatabaseHas('fixtures', [
        'country_id_1' => $country1->id,
        'country_id_2' => $country2->id,
        'group_id' => $group->id,
        'created_by' => $user->id,
    ]);
});

test('users can update fixtures', function () {
    $user = User::factory()->create();
    $country1 = Country::factory()->create();
    $country2 = Country::factory()->create();
    $country3 = Country::factory()->create();
    $group = Group::factory()->create();

    $fixture = Fixture::create([
        'country_id_1' => $country1->id,
        'country_id_2' => $country2->id,
        'group_id' => $group->id,
        'match_date' => '2026-06-11 20:00:00',
        'created_by' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('fixtures.update', $fixture->id), [
            'country_id_1' => $country1->id,
            'country_id_2' => $country3->id,
            'group_id' => $group->id,
            'match_date' => '2026-06-12 20:00',
            'gol_1' => 2,
            'gol_2' => 1,
            'played' => true,
            'penalties' => false,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('fixtures.index'));

    $this->assertDatabaseHas('fixtures', [
        'id' => $fixture->id,
        'country_id_2' => $country3->id,
        'gol_1' => 2,
        'gol_2' => 1,
        'played' => true,
        'updated_by' => $user->id,
    ]);
});

test('users can delete fixtures', function () {
    $user = User::factory()->create();
    $country1 = Country::factory()->create();
    $country2 = Country::factory()->create();
    $group = Group::factory()->create();

    $fixture = Fixture::create([
        'country_id_1' => $country1->id,
        'country_id_2' => $country2->id,
        'group_id' => $group->id,
        'match_date' => '2026-06-11 20:00:00',
        'created_by' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route('fixtures.destroy', $fixture->id));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('fixtures.index'));

    $this->assertSoftDeleted('fixtures', [
        'id' => $fixture->id,
        'deleted_by' => $user->id,
    ]);
});
<?php

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
