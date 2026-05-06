<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:todo,in_progress,done',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Le statut est obligatoire',
            'status.in'       => 'Le statut doit être : todo, in_progress ou done',
        ];
    }
}