<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // filtre reel gere par ClientPolicy dans le controleur
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:prospect,client'],
            'nom' => ['required', 'string', 'max:255'],
            'entreprise' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'adresse' => ['nullable', 'string'],
            'source' => ['nullable', 'string', 'max:100'],
            'statut' => ['required', 'in:actif,inactif'],
            'commercial_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
