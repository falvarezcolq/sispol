<?php

use App\Models\Card;
use App\Models\User;

test('authenticated users can visit cards index', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('cards.index'));

    $response->assertOk();
});

test('users can create cards', function () {
    $user = User::factory()->create();
    $owner = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('cards.store'), [
            'user_id' => $owner->id,
            'card_number' => 123456,
            'balance' => 100.50,
            'card_type' => 'Debito',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('cards.index'));

    $this->assertDatabaseHas('cards', [
        'user_id' => $owner->id,
        'card_number' => 123456,
        'card_type' => 'Debito',
        'created_by' => $user->id,
    ]);
});

test('users can update cards', function () {
    $user = User::factory()->create();
    $owner = User::factory()->create();
    $newOwner = User::factory()->create();

    $card = Card::create([
        'user_id' => $owner->id,
        'card_number' => 111222,
        'balance' => 50.00,
        'card_type' => 'Credito',
        'created_by' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('cards.update', $card), [
            'user_id' => $newOwner->id,
            'card_number' => 333444,
            'balance' => 250.75,
            'card_type' => 'Debito',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('cards.index'));

    $this->assertDatabaseHas('cards', [
        'id' => $card->id,
        'user_id' => $newOwner->id,
        'card_number' => 333444,
        'card_type' => 'Debito',
        'updated_by' => $user->id,
    ]);
});

test('users can delete cards', function () {
    $user = User::factory()->create();
    $owner = User::factory()->create();

    $card = Card::create([
        'user_id' => $owner->id,
        'card_number' => 999888,
        'balance' => 10.00,
        'card_type' => 'Debito',
        'created_by' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route('cards.destroy', $card));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('cards.index'));

    $card->refresh();

    expect($card->deleted_by)->toBe($user->id);
    $this->assertSoftDeleted('cards', [
        'id' => $card->id,
    ]);
});
