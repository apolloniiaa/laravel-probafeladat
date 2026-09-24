<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReferenceRequest;
use App\Models\Reference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReferenceController extends Controller
{
    public function index(): View
    {
        return view('admin.references.index', [
            'references' => Reference::query()->newestFirst()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.references.create', ['reference' => new Reference]);
    }

    public function store(ReferenceRequest $request): RedirectResponse
    {
        $reference = new Reference($request->safe()->only(['title', 'reference_date']));
        $reference->image_path = $request->file('image')->store('references', 'public');
        $reference->save();

        return to_route('admin.references.index')->with('status', 'A referencia létrehozva.');
    }

    public function edit(Reference $reference): View
    {
        return view('admin.references.edit', ['reference' => $reference]);
    }

    public function update(ReferenceRequest $request, Reference $reference): RedirectResponse
    {
        $previousImage = $reference->image_path;

        $reference->fill($request->safe()->only(['title', 'reference_date']));

        if ($request->hasFile('image')) {
            $reference->image_path = $request->file('image')->store('references', 'public');
        }

        $reference->save();

        if ($previousImage !== $reference->image_path) {
            Storage::disk('public')->delete($previousImage);
        }

        return to_route('admin.references.index')->with('status', 'A referencia mentve.');
    }

    public function destroy(Reference $reference): RedirectResponse
    {
        $reference->delete();
        Storage::disk('public')->delete($reference->image_path);

        return to_route('admin.references.index')->with('status', 'A referencia törölve.');
    }
}
