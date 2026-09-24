<?php

test('a valid contact message is accepted', function () {
    $this->postJson(route('contact.store'), [
        'name' => 'Kovács Anna',
        'email' => 'anna@example.com',
        'message' => 'Szeretnék ajánlatot kérni egy egyedi acélszerkezetre.',
    ])
        ->assertOk()
        ->assertJson([
            'message' => 'Köszönjük! Üzenetét megkaptuk, hamarosan felvesszük Önnel a kapcsolatot.',
        ]);
});

test('all contact fields are required', function () {
    $this->postJson(route('contact.store'), [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'name' => 'Kérjük, adja meg a nevét.',
            'email' => 'Kérjük, adja meg az e-mail címét.',
            'message' => 'Kérjük, írja meg az üzenetét.',
        ]);
});

test('the contact e-mail address must be valid', function () {
    $this->postJson(route('contact.store'), [
        'name' => 'Kovács Anna',
        'email' => 'not-an-email',
        'message' => 'Szia!',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => 'Kérjük, érvényes e-mail címet adjon meg.'])
        ->assertJsonMissingValidationErrors(['name', 'message']);
});

test('contact submissions are rate limited', function () {
    $payload = ['name' => 'Kovács Anna', 'email' => 'anna@example.com', 'message' => 'Szia!'];

    foreach (range(1, 6) as $attempt) {
        $this->postJson(route('contact.store'), $payload)->assertOk();
    }

    $this->postJson(route('contact.store'), $payload)->assertTooManyRequests();
});

test('the contact modal renders the form with a csrf token', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('action="'.route('contact.store').'"', false)
        ->assertSee('data-contact-form', false)
        ->assertSee('name="_token"', false);
});
