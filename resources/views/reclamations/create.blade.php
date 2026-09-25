@extends('layouts.app')

@section('titre', 'Nouvelle reclamation')

@section('contenu')
<h1 class="text-2xl font-semibold mb-6">Nouvelle reclamation</h1>

<form method="POST" action="{{ route('reclamations.store') }}" class="bg-white rounded shadow p-6 max-w-2xl space-y-4">
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
        <label class="block text-sm font-medium mb-1">Sujet</label>
        <input type="text" name="sujet" value="{{ old('sujet') }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full border rounded px-3 py-2" required>{{ old('description') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Priorite</label>
            <select name="priorite" class="w-full border rounded px-3 py-2">
                @foreach (['basse', 'normale', 'haute', 'critique'] as $priorite)
                    <option value="{{ $priorite }}" @selected(old('priorite', 'normale') === $priorite)>{{ ucfirst($priorite) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Assigne a</label>
            <select name="assigned_to" class="w-full border rounded px-3 py-2">
                <option value="">— Non assigne —</option>
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}" @selected(old('assigned_to') == $agent->id)>{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <input type="hidden" name="statut" value="ouverte">

    <div class="flex justify-end gap-3">
        <a href="{{ route('reclamations.index') }}" class="px-4 py-2 rounded border">Annuler</a>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
    </div>
</form>
@endsection
