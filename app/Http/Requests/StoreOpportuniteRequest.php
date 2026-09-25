<?php

namespace App\Http\Requests;

use App\Models\Opportunite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOpportuniteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'commercial_id' => ['required', 'exists:users,id'],
            'titre' => ['required', 'string', 'max:255'],
            'montant' => ['required', 'numeric', 'min:0'],
            'etape' => ['required', Rule::in(Opportunite::ETAPES)],
            'probabilite' => ['required', 'integer', 'min:0', 'max:100'],
            'date_cloture_prevue' => ['nullable', 'date'],
        ];
    }
}
