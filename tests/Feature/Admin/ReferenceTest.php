<?php

use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

test('guests cannot access the reference admin', function () {
    $reference = Reference::factory()->create();

    $this->get(route('admin.references.index'))->assertUnauthorized();
    $this->get(route('admin.references.create'))->assertUnauthorized();
    $this->post(route('admin.references.store'))->assertUnauthorized();
    $this->get(route('admin.references.edit', $reference))->assertUnauthorized();
    $this->put(route('admin.references.update', $reference))->assertUnauthorized();
    $this->delete(route('admin.references.destroy', $reference))->assertUnauthorized();
});

test('the admin lists the references', function () {
    Reference::factory()->create(['title' => 'Lépcsőkorlát']);

    $this->actingAs(User::factory()->create())
        ->get(route('admin.references.index'))
        ->assertOk()
        ->assertSee('Lépcsőkorlát');
});

test('an admin can create a reference with a cover image', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('admin.references.store'), [
            'title' => 'Lépcsőkorlát',
            'reference_date' => '2026-06-01',
            'image' => UploadedFile::fake()->image('cover.jpg', 720, 540),
        ])
        ->assertRedirect(route('admin.references.index'))
        ->assertSessionHasNoErrors();

    $reference = Reference::sole();

    expect($reference->title)->toBe('Lépcsőkorlát')
        ->and($reference->reference_date->toDateString())->toBe('2026-06-01')
        ->and($reference->image_path)->toStartWith('references/');
    Storage::disk('public')->assertExists($reference->image_path);
});

test('an admin can update a reference and replace its image', function () {
    $previous = UploadedFile::fake()->image('old.jpg', 720, 540)->store('references', 'public');
    $reference = Reference::factory()->create(['image_path' => $previous]);

    $this->actingAs(User::factory()->create())
        ->put(route('admin.references.update', $reference), [
            'title' => 'Új cím',
            'reference_date' => '2026-07-15',
            'image' => UploadedFile::fake()->image('new.jpg', 720, 540),
        ])
        ->assertRedirect(route('admin.references.index'))
        ->assertSessionHasNoErrors();

    $reference->refresh();

    expect($reference->title)->toBe('Új cím')
        ->and($reference->reference_date->toDateString())->toBe('2026-07-15');
    Storage::disk('public')->assertMissing($previous);
    Storage::disk('public')->assertExists($reference->image_path);
});

test('a reference can be updated without replacing its image', function () {
    $image = UploadedFile::fake()->image('cover.jpg', 720, 540)->store('references', 'public');
    $reference = Reference::factory()->create(['image_path' => $image]);

    $this->actingAs(User::factory()->create())
        ->put(route('admin.references.update', $reference), [
            'title' => 'Új cím',
            'reference_date' => '2026-07-15',
        ])
        ->assertSessionHasNoErrors();

    expect($reference->fresh()->image_path)->toBe($image);
    Storage::disk('public')->assertExists($image);
});

test('an admin can delete a reference and its image', function () {
    $image = UploadedFile::fake()->image('cover.jpg', 720, 540)->store('references', 'public');
    $reference = Reference::factory()->create(['image_path' => $image]);

    $this->actingAs(User::factory()->create())
        ->delete(route('admin.references.destroy', $reference))
        ->assertRedirect(route('admin.references.index'));

    $this->assertModelMissing($reference);
    Storage::disk('public')->assertMissing($image);
});

test('a new reference is validated', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('admin.references.store'), [
            'title' => '',
            'reference_date' => 'not-a-date',
        ])
        ->assertSessionHasErrors([
            'title' => 'Kérjük, adja meg a referencia címét.',
            'reference_date' => 'Kérjük, érvényes dátumot adjon meg.',
            'image' => 'Kérjük, válasszon borítóképet.',
        ]);

    $this->actingAs(User::factory()->create())
        ->post(route('admin.references.store'), [
            'title' => 'Lépcsőkorlát',
            'reference_date' => '2026-06-01',
            'image' => UploadedFile::fake()->create('cover.pdf', 100, 'application/pdf'),
        ])
        ->assertSessionHasErrors('image');

    $this->actingAs(User::factory()->create())
        ->post(route('admin.references.store'), [
            'title' => 'Lépcsőkorlát',
            'reference_date' => '2026-06-01',
            'image' => UploadedFile::fake()->image('small.jpg', 200, 150),
        ])
        ->assertSessionHasErrors(['image' => 'A kép legalább 360×270 pixel legyen.']);

    expect(Reference::count())->toBe(0);
});

test('the home page lists references from newest to oldest', function () {
    Reference::factory()->create(['title' => 'Régebbi munka', 'reference_date' => '2025-01-10']);
    $newest = Reference::factory()->create(['title' => 'Legújabb munka', 'reference_date' => '2026-08-20']);
    Reference::factory()->create(['title' => 'Középső munka', 'reference_date' => '2025-11-05']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSeeInOrder(['Legújabb munka', 'Középső munka', 'Régebbi munka'])
        ->assertSee($newest->image_url)
        ->assertSee('2026.08.20')
        ->assertDontSee('Acél kényelmi eszközök');
});

test('the home page falls back to the default references', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSeeInOrder([
            'Acél kényelmi eszközök',
            'Beltéri szerkezetek és térelválasztók',
            'Kültéri építészeti megoldások',
            'Egyedi fémszerkezetek',
        ])
        ->assertSee(asset('images/references/acel-kenyelmi-eszkozok.png'));
});
