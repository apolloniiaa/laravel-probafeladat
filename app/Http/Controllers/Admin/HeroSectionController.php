<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateHeroSectionRequest;
use App\Models\HeroSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroSectionController extends Controller
{
    public function edit(): View
    {
        return view('admin.hero.edit', ['hero' => HeroSection::current()]);
    }

    public function update(UpdateHeroSectionRequest $request): RedirectResponse
    {
        $hero = HeroSection::current();
        $previousImage = $hero->image_path;

        $hero->fill($request->safe()->only(['title', 'description']));

        if ($request->hasFile('image')) {
            $hero->image_path = $request->file('image')->store('hero', 'public');
        }

        $hero->save();

        if ($previousImage && $previousImage !== $hero->image_path) {
            Storage::disk('public')->delete($previousImage);
        }

        return to_route('admin.hero.edit')->with('status', 'A hero szekció mentve.');
    }
}
