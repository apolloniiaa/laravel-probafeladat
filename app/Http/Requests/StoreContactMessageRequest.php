<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:filter', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Kérjük, adja meg a nevét.',
            'name.max' => 'A név legfeljebb 255 karakter lehet.',
            'email.required' => 'Kérjük, adja meg az e-mail címét.',
            'email.email' => 'Kérjük, érvényes e-mail címet adjon meg.',
            'email.max' => 'Az e-mail cím legfeljebb 255 karakter lehet.',
            'message.required' => 'Kérjük, írja meg az üzenetét.',
            'message.max' => 'Az üzenet legfeljebb 5000 karakter lehet.',
        ];
    }
}
