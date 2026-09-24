<?php

use App\Models\HeroSection;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

test('guests cannot access the hero admin', function () {
    $this->get(route('admin.hero.edit'))->assertUnauthorized();
    $this->put(route('admin.hero.update'))->assertUnauthorized();
});

test('the edit form shows the current hero content', function () {
    HeroSection::factory()->create(['title' => 'Mentett főcím']);

    $this->actingAs(User::factory()->create())
        ->get(route('admin.hero.edit'))
        ->assertOk()
        ->assertSee('Mentett főcím');
});

test('an admin can update the hero text and image', function () {
    $this->actingAs(User::factory()->create())
        ->put(route('admin.hero.update'), [
            'title' => 'Új főcím',
            'description' => 'Új leírás.',
            'image' => UploadedFile::fake()->image('hero.jpg', 1920, 780),
        ])
        ->assertRedirect(route('admin.hero.edit'))
        ->assertSessionHasNoErrors();

    $hero = HeroSection::sole();

    expect($hero->title)->toBe('Új főcím')
        ->and($hero->description)->toBe('Új leírás.');
    Storage::disk('public')->assertExists($hero->image_path);

    $this->get(route('home'))
        ->assertSee('Új főcím')
        ->assertSee('Új leírás.')
        ->assertSee(asset('storage/'.$hero->image_path));
});

test('the text can be updated without replacing the image', function () {
    $hero = HeroSection::factory()->create(['image_path' => 'hero/current.jpg']);

    $this->actingAs(User::factory()->create())
        ->put(route('admin.hero.update'), ['title' => 'Új főcím', 'description' => 'Új leírás.'])
        ->assertSessionHasNoErrors();

    expect($hero->fresh()->image_path)->toBe('hero/current.jpg');
});

test('replacing the hero image deletes the previous upload', function () {
    $previous = UploadedFile::fake()->image('old.jpg', 1920, 780)->store('hero', 'public');
    HeroSection::factory()->create(['image_path' => $previous]);

    $this->actingAs(User::factory()->create())
        ->put(route('admin.hero.update'), [
            'title' => 'Főcím',
            'description' => 'Leírás.',
            'image' => UploadedFile::fake()->image('new.jpg', 1920, 780),
        ])
        ->assertSessionHasNoErrors();

    Storage::disk('public')->assertMissing($previous);
    Storage::disk('public')->assertExists(HeroSection::sole()->image_path);
});

test('the hero content is validated', function () {
    $this->actingAs(User::factory()->create())
        ->put(route('admin.hero.update'), [
            'title' => '',
            'description' => '',
            'image' => UploadedFile::fake()->create('hero.pdf', 100, 'application/pdf'),
        ])
        ->assertSessionHasErrors([
            'title' => 'Kérjük, adja meg a főcímet.',
            'description' => 'Kérjük, adja meg a leírást.',
            'image',
        ]);

    $this->actingAs(User::factory()->create())
        ->put(route('admin.hero.update'), [
            'title' => 'Főcím',
            'description' => 'Leírás.',
            'image' => UploadedFile::fake()->image('small.jpg', 800, 400),
        ])
        ->assertSessionHasErrors(['image' => 'A kép legalább 1280×520 pixel legyen.']);

    expect(HeroSection::count())->toBe(0);
});

test('the home page falls back to the default hero content', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Tárgyak, amelyek kiállják az idő próbáját')
        ->assertSee(asset('images/hero.png'));
});
