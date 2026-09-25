@extends('layouts.app')

@section('titre', 'Reclamations')

@section('contenu')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Reclamations</h1>
    <a href="{{ route('reclamations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Nouvelle reclamation
    </a>
</div>

<form method="GET" class="flex gap-3 mb-4">
    <select name="statut" class="border rounded px-3 py-2">
        <option value="">Tous statuts</option>
        @foreach (['ouverte', 'en_cours', 'resolue', 'fermee'] as $statut)
            <option value="{{ $statut }}" @selected(request('statut') === $statut)>{{ ucfirst(str_replace('_', ' ', $statut)) }}</option>
        @endforeach
    </select>
    <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Filtrer</button>
</form>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Sujet</th>
                <th class="px-4 py-2">Client</th>
                <th class="px-4 py-2">Priorite</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2">Assigne a</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($reclamations as $reclamation)
                <tr>
                    <td class="px-4 py-2">{{ $reclamation->sujet }}</td>
                    <td class="px-4 py-2">{{ $reclamation->client->nom }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 rounded-full text-xs
                            {{ match($reclamation->priorite) {
                                'critique' => 'bg-red-100 text-red-700',
                                'haute' => 'bg-orange-100 text-orange-700',
                                'normale' => 'bg-blue-100 text-blue-700',
                                default => 'bg-gray-100 text-gray-700',
                            } }}">
                            {{ ucfirst($reclamation->priorite) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ ucfirst(str_replace('_', ' ', $reclamation->statut)) }}</td>
                    <td class="px-4 py-2">{{ $reclamation->agent->name ?? '—' }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('reclamations.show', $reclamation) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucune reclamation.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $reclamations->links() }}</div>
@endsection
