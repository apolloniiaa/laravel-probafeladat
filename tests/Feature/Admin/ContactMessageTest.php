<?php

use App\Models\ContactMessage;
use App\Models\User;

test('guests cannot access the message inbox', function () {
    $this->get(route('admin.messages.index'))->assertUnauthorized();
});

test('the inbox shows an empty state', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.messages.index'))
        ->assertOk()
        ->assertSee('Még nem érkezett üzenet.');
});

test('the inbox lists messages newest first', function () {
    ContactMessage::factory()->create(['name' => 'Régebbi feladó', 'created_at' => now()->subDays(2)]);
    $newest = ContactMessage::factory()->create([
        'name' => 'Legújabb feladó',
        'email' => 'uj@example.com',
        'message' => 'Ajánlatot kérnék.',
        'created_at' => now(),
    ]);
    ContactMessage::factory()->create(['name' => 'Középső feladó', 'created_at' => now()->subDay()]);

    $this->actingAs(User::factory()->create())
        ->get(route('admin.messages.index'))
        ->assertOk()
        ->assertSeeInOrder(['Legújabb feladó', 'Középső feladó', 'Régebbi feladó'])
        ->assertSee('uj@example.com')
        ->assertSee('Ajánlatot kérnék.')
        ->assertSee($newest->created_at->format('Y.m.d H:i'));
});

test('message content is escaped in the inbox', function () {
    ContactMessage::factory()->create(['message' => '<script>alert(1)</script>']);

    $this->actingAs(User::factory()->create())
        ->get(route('admin.messages.index'))
        ->assertOk()
        ->assertDontSee('<script>alert(1)</script>', false)
        ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
});
