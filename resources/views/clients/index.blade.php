@extends('layouts.app')

@section('titre', 'Clients & Prospects')

@section('contenu')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Clients &amp; Prospects</h1>
    <a href="{{ route('clients.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Nouveau
    </a>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-4">
    <input type="text" name="recherche" value="{{ request('recherche') }}" placeholder="Rechercher (nom, entreprise, email)"
           class="border rounded px-3 py-2 w-72">
    <select name="type" class="border rounded px-3 py-2">
        <option value="">Tous types</option>
        <option value="prospect" @selected(request('type') === 'prospect')>Prospect</option>
        <option value="client" @selected(request('type') === 'client')>Client</option>
    </select>
    <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Filtrer</button>
</form>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Entreprise</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Commercial</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($clients as $client)
                <tr>
                    <td class="px-4 py-2">{{ $client->nom }}</td>
                    <td class="px-4 py-2">{{ $client->entreprise ?? '—' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $client->type === 'client' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($client->type) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $client->commercial->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ ucfirst($client->statut) }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucun client trouve.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $clients->links() }}</div>
@endsection
