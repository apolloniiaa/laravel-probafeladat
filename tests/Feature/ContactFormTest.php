<?php

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Mail::fake();
    config(['mail.admin_addresses' => ['admin@example.com']]);
});

test('a valid contact message is stored', function () {
    $this->postJson(route('contact.store'), [
        'name' => 'Kovács Anna',
        'email' => 'anna@example.com',
        'message' => 'Szeretnék ajánlatot kérni egy egyedi acélszerkezetre.',
    ])
        ->assertOk()
        ->assertJson([
            'message' => 'Köszönjük! Üzenetét megkaptuk, hamarosan felvesszük Önnel a kapcsolatot.',
        ]);

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Kovács Anna',
        'email' => 'anna@example.com',
        'message' => 'Szeretnék ajánlatot kérni egy egyedi acélszerkezetre.',
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

    $this->assertDatabaseEmpty('contact_messages');
    Mail::assertNothingSent();
});

test('the contact e-mail address must be valid', function (string $email) {
    $this->postJson(route('contact.store'), [
        'name' => 'Kovács Anna',
        'email' => $email,
        'message' => 'Szia!',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => 'Kérjük, érvényes e-mail címet adjon meg.'])
        ->assertJsonMissingValidationErrors(['name', 'message']);

    $this->assertDatabaseEmpty('contact_messages');
    Mail::assertNothingSent();
})->with(['not-an-email', 'test@gmail']);

test('complete e-mail addresses are accepted', function (string $email) {
    $this->postJson(route('contact.store'), [
        'name' => 'Kovács Anna',
        'email' => $email,
        'message' => 'Szia!',
    ])->assertOk();

    $this->assertDatabaseHas('contact_messages', ['email' => $email]);
})->with(['test@gmail.com', 'name@example.hu']);

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

test('the administrators are notified about a new message', function () {
    $this->postJson(route('contact.store'), [
        'name' => 'Kovács Anna',
        'email' => 'anna@example.com',
        'message' => 'Szia!',
    ])->assertOk();

    Mail::assertSent(NewContactMessage::class, fn (NewContactMessage $mail) => $mail->hasTo('admin@example.com')
        && $mail->contactMessage->is(ContactMessage::sole()));
});

test('no notification is sent when no administrator address is configured', function () {
    config(['mail.admin_addresses' => []]);

    $this->postJson(route('contact.store'), [
        'name' => 'Kovács Anna',
        'email' => 'anna@example.com',
        'message' => 'Szia!',
    ])->assertOk();

    $this->assertDatabaseCount('contact_messages', 1);
    Mail::assertNothingSent();
});

test('a failing notification does not fail a stored submission', function () {
    Mail::shouldReceive('to')->andThrow(new RuntimeException('Mail transport unavailable.'));

    $this->postJson(route('contact.store'), [
        'name' => 'Kovács Anna',
        'email' => 'anna@example.com',
        'message' => 'Szia!',
    ])->assertOk();

    $this->assertDatabaseCount('contact_messages', 1);
});

test('the notification contains the message details', function () {
    $contactMessage = ContactMessage::factory()->create([
        'name' => 'Kovács Anna',
        'email' => 'anna@example.com',
        'message' => 'Ajánlatot kérnék egy korláthoz.',
        'created_at' => '2026-09-25 14:30:00',
    ]);

    $mail = new NewContactMessage($contactMessage);

    $mail->assertHasSubject('Új üzenet érkezett: Kovács Anna');
    $mail->assertHasReplyTo('anna@example.com', 'Kovács Anna');
    $mail->assertSeeInHtml('Kovács Anna');
    $mail->assertSeeInHtml('anna@example.com');
    $mail->assertSeeInHtml('Ajánlatot kérnék egy korláthoz.');
    $mail->assertSeeInHtml('2026.09.25 14:30');
});
