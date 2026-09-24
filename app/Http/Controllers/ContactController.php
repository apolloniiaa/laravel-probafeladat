<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        Log::info('Contact form submitted.', $request->safe()->only(['name', 'email']));

        return response()->json([
            'message' => 'Köszönjük! Üzenetét megkaptuk, hamarosan felvesszük Önnel a kapcsolatot.',
        ]);
    }
}
