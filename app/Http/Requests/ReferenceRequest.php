<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReferenceRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'reference_date' => ['required', 'date'],
            'image' => [
                $this->route('reference') ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
                'dimensions:min_width=360,min_height=270',
            ],
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
            'title.required' => 'Kérjük, adja meg a referencia címét.',
            'title.max' => 'A cím legfeljebb 255 karakter lehet.',
            'reference_date.required' => 'Kérjük, adja meg a dátumot.',
            'reference_date.date' => 'Kérjük, érvényes dátumot adjon meg.',
            'image.required' => 'Kérjük, válasszon borítóképet.',
            'image.uploaded' => 'A kép feltöltése nem sikerült. Ellenőrizze a fájl méretét.',
            'image.image' => 'A feltöltött fájl nem kép.',
            'image.mimes' => 'A kép JPG, PNG vagy WebP formátumú lehet.',
            'image.max' => 'A kép legfeljebb 5 MB lehet.',
            'image.dimensions' => 'A kép legalább 360×270 pixel legyen.',
        ];
    }
}
