<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInteractionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:appel,email,rdv,note'],
            'date_interaction' => ['required', 'date'],
            'description' => ['required', 'string'],
            'resultat' => ['nullable', 'string', 'max:255'],
        ];
    }
}
