@extends('layouts.app')

@section('titre', $reclamation->sujet)

@section('contenu')
<h1 class="text-2xl font-semibold mb-6">{{ $reclamation->sujet }}</h1>

<div class="grid grid-cols-3 gap-6">
    <div class="bg-white rounded shadow p-4 text-sm space-y-2">
        <p><strong>Client :</strong> <a href="{{ route('clients.show', $reclamation->client) }}" class="text-blue-600 hover:underline">{{ $reclamation->client->nom }}</a></p>
        <p><strong>Priorite :</strong> {{ ucfirst($reclamation->priorite) }}</p>
        <p><strong>Assigne a :</strong> {{ $reclamation->agent->name ?? '—' }}</p>
        <p><strong>Cree le :</strong> {{ $reclamation->created_at->format('d/m/Y H:i') }}</p>
        @if ($reclamation->date_resolution)
            <p><strong>Resolue le :</strong> {{ $reclamation->date_resolution->format('d/m/Y H:i') }}</p>
        @endif
    </div>

    <div class="col-span-2 space-y-6">
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-2">Description</h2>
            <p>{{ $reclamation->description }}</p>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Changer le statut</h2>
            <form method="POST" action="{{ route('reclamations.update', $reclamation) }}" class="flex gap-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="client_id" value="{{ $reclamation->client_id }}">
                <input type="hidden" name="sujet" value="{{ $reclamation->sujet }}">
                <input type="hidden" name="description" value="{{ $reclamation->description }}">
                <input type="hidden" name="priorite" value="{{ $reclamation->priorite }}">
                <input type="hidden" name="assigned_to" value="{{ $reclamation->assigned_to }}">
                <select name="statut" class="border rounded px-3 py-2">
                    @foreach (['ouverte', 'en_cours', 'resolue', 'fermee'] as $statut)
                        <option value="{{ $statut }}" @selected($reclamation->statut === $statut)>{{ ucfirst(str_replace('_', ' ', $statut)) }}</option>
                    @endforeach
                </select>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Mettre a jour</button>
            </form>
        </div>
    </div>
</div>
@endsection
