<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'priority'    => 'required|in:low,medium,high',
            'deadline'    => 'required|date',
            'assigned_to' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Le titre est obligatoire',
            'priority.required'    => 'La priorité est obligatoire',
            'deadline.required'    => 'La deadline est obligatoire',
            'assigned_to.required' => 'Vous devez assigner la tâche à un développeur',
            'assigned_to.exists'   => 'Ce développeur n\'existe pas',
        ];
    }
}