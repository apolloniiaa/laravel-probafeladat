<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroSectionRequest extends FormRequest
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
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120', 'dimensions:min_width=1280,min_height=520'],
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
            'title.required' => 'Kérjük, adja meg a főcímet.',
            'title.max' => 'A főcím legfeljebb 255 karakter lehet.',
            'description.required' => 'Kérjük, adja meg a leírást.',
            'description.max' => 'A leírás legfeljebb 1000 karakter lehet.',
            'image.uploaded' => 'A kép feltöltése nem sikerült. Ellenőrizze a fájl méretét.',
            'image.image' => 'A feltöltött fájl nem kép.',
            'image.mimes' => 'A kép JPG, PNG vagy WebP formátumú lehet.',
            'image.max' => 'A kép legfeljebb 5 MB lehet.',
            'image.dimensions' => 'A kép legalább 1280×520 pixel legyen.',
        ];
    }
}
