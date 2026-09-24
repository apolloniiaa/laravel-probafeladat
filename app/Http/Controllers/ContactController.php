<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        $contactMessage = ContactMessage::create($request->validated());

        if ($recipients = config('mail.admin_addresses')) {
            rescue(fn () => Mail::to($recipients)->send(new NewContactMessage($contactMessage)));
        }

        return response()->json([
            'message' => 'Köszönjük! Üzenetét megkaptuk, hamarosan felvesszük Önnel a kapcsolatot.',
        ]);
    }
}
