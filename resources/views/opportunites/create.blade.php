@extends('layouts.app')

@section('titre', 'Nouvelle opportunite')

@section('contenu')
<h1 class="text-2xl font-semibold mb-6">Nouvelle opportunite</h1>

<form method="POST" action="{{ route('opportunites.store') }}" class="bg-white rounded shadow p-6 max-w-2xl space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Client</label>
        <select name="client_id" class="w-full border rounded px-3 py-2" required>
            <option value="">— Choisir —</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->nom }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Commercial</label>
        <select name="commercial_id" class="w-full border rounded px-3 py-2" required>
            <option value="">— Choisir —</option>
            @foreach ($commerciaux as $commercial)
                <option value="{{ $commercial->id }}" @selected(old('commercial_id') == $commercial->id)>{{ $commercial->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Titre</label>
        <input type="text" name="titre" value="{{ old('titre') }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Montant</label>
            <input type="number" step="0.01" name="montant" value="{{ old('montant', 0) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Probabilite (%)</label>
            <input type="number" min="0" max="100" name="probabilite" value="{{ old('probabilite', 20) }}" class="w-full border rounded px-3 py-2" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Etape</label>
            <select name="etape" class="w-full border rounded px-3 py-2">
                @foreach (\App\Models\Opportunite::ETAPES as $etape)
                    <option value="{{ $etape }}" @selected(old('etape', 'prospection') === $etape)>{{ ucfirst($etape) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Date de cloture prevue</label>
            <input type="date" name="date_cloture_prevue" value="{{ old('date_cloture_prevue') }}" class="w-full border rounded px-3 py-2">
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('opportunites.index') }}" class="px-4 py-2 rounded border">Annuler</a>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
    </div>
</form>
@endsection
