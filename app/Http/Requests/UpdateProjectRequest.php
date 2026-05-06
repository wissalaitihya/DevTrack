<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Le titre est obligatoire',
            'deadline.required' => 'La deadline est obligatoire',
        ];
    }
}