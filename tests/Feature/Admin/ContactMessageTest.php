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

function exportedRows(string $csv): array
{
    $stream = fopen('php://memory', 'r+');
    fwrite($stream, $csv);
    rewind($stream);

    $rows = [];

    while (($row = fgetcsv($stream, null, ';', '"', '')) !== false) {
        $rows[] = $row;
    }

    return $rows;
}

test('guests cannot export the messages', function () {
    $this->get(route('admin.messages.export'))->assertUnauthorized();
});

test('an admin can download the messages as csv', function () {
    ContactMessage::factory()->create([
        'name' => 'Kovács Anna',
        'email' => 'anna@example.com',
        'message' => 'Ajánlatot kérnék.',
        'created_at' => '2026-09-25 14:30:00',
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->get(route('admin.messages.export'))
        ->assertOk()
        ->assertDownload('contact-messages.csv')
        ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

    $csv = $response->streamedContent();

    expect($csv)->toStartWith("\xEF\xBB\xBF")
        ->and(exportedRows(substr($csv, 3)))->toBe([
            ['Név', 'E-mail', 'Üzenet', 'Beküldve'],
            ['Kovács Anna', 'anna@example.com', 'Ajánlatot kérnék.', '2026.09.25 14:30'],
        ]);
});

test('the export preserves special characters and line breaks', function () {
    $message = "Szia, \"FÉM\" csapat!\nÁrvíztűrő tükörfúrógép; második sor.";
    ContactMessage::factory()->create(['name' => 'Őri Ödön', 'message' => $message]);

    $csv = $this->actingAs(User::factory()->create())
        ->get(route('admin.messages.export'))
        ->streamedContent();

    $row = exportedRows(substr($csv, 3))[1];

    expect($row[0])->toBe('Őri Ödön')
        ->and($row[2])->toBe($message);
});

test('the export neutralises spreadsheet formulas', function () {
    ContactMessage::factory()->create(['name' => '=HYPERLINK("https://example.com")']);

    $csv = $this->actingAs(User::factory()->create())
        ->get(route('admin.messages.export'))
        ->streamedContent();

    expect(exportedRows(substr($csv, 3))[1][0])->toBe('\'=HYPERLINK("https://example.com")');
});

test('messages are exported newest first', function () {
    ContactMessage::factory()->create(['name' => 'Régebbi feladó', 'created_at' => now()->subDays(2)]);
    ContactMessage::factory()->create(['name' => 'Legújabb feladó', 'created_at' => now()]);
    ContactMessage::factory()->create(['name' => 'Középső feladó', 'created_at' => now()->subDay()]);

    $csv = $this->actingAs(User::factory()->create())
        ->get(route('admin.messages.export'))
        ->streamedContent();

    expect(array_column(array_slice(exportedRows(substr($csv, 3)), 1), 0))
        ->toBe(['Legújabb feladó', 'Középső feladó', 'Régebbi feladó']);
});

test('the inbox links to the export', function () {
    ContactMessage::factory()->create();

    $this->actingAs(User::factory()->create())
        ->get(route('admin.messages.index'))
        ->assertSee(route('admin.messages.export'));
});
