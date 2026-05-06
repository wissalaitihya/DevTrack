<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // La Policy gère l'autorisation
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Le titre est obligatoire',
            'deadline.required' => 'La deadline est obligatoire',
            'deadline.after'    => 'La deadline doit être dans le futur',
        ];
    }
}