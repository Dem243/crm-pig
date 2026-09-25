<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReclamationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'sujet' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'statut' => ['required', 'in:ouverte,en_cours,resolue,fermee'],
            'priorite' => ['required', 'in:basse,normale,haute,critique'],
        ];
    }
}
