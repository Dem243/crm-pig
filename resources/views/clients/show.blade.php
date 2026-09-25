@extends('layouts.app')

@section('titre', $client->nom)

@section('contenu')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">{{ $client->nom }}</h1>
        <p class="text-gray-500">{{ $client->entreprise }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('clients.edit', $client) }}" class="px-4 py-2 rounded border">Modifier</a>
    </div>
</div>

<div class="grid grid-cols-3 gap-6">
    {{-- Colonne infos --}}
    <div class="bg-white rounded shadow p-4 space-y-2 text-sm">
        <h2 class="font-semibold mb-2">Informations</h2>
        <p><strong>Type :</strong> {{ ucfirst($client->type) }}</p>
        <p><strong>Email :</strong> {{ $client->email ?? '—' }}</p>
        <p><strong>Telephone :</strong> {{ $client->telephone ?? '—' }}</p>
        <p><strong>Adresse :</strong> {{ $client->adresse ?? '—' }}</p>
        <p><strong>Source :</strong> {{ $client->source ?? '—' }}</p>
        <p><strong>Commercial :</strong> {{ $client->commercial->name ?? '—' }}</p>
    </div>

    {{-- Colonne interactions --}}
    <div class="col-span-2 space-y-6">
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Nouvelle interaction</h2>
            <form method="POST" action="{{ route('clients.interactions.store', $client) }}" class="grid grid-cols-2 gap-3">
                @csrf
                <select name="type" class="border rounded px-3 py-2">
                    <option value="appel">Appel</option>
                    <option value="email">Email</option>
                    <option value="rdv">Rendez-vous</option>
                    <option value="note">Note</option>
                </select>
                <input type="datetime-local" name="date_interaction" class="border rounded px-3 py-2" required>
                <textarea name="description" placeholder="Description" class="border rounded px-3 py-2 col-span-2" required></textarea>
                <input type="text" name="resultat" placeholder="Resultat (optionnel)" class="border rounded px-3 py-2 col-span-2">
                <button class="bg-blue-600 text-white px-4 py-2 rounded col-span-2 justify-self-end">Ajouter</button>
            </form>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Historique des interactions</h2>
            <ul class="space-y-3">
                @forelse ($client->interactions as $interaction)
                    <li class="border-l-4 border-blue-400 pl-3">
                        <div class="text-sm text-gray-500">
                            {{ ucfirst($interaction->type) }} — {{ $interaction->date_interaction->format('d/m/Y H:i') }}
                            par {{ $interaction->user->name }}
                        </div>
                        <p>{{ $interaction->description }}</p>
                        @if ($interaction->resultat)
                            <p class="text-sm text-gray-600">Resultat : {{ $interaction->resultat }}</p>
                        @endif
                    </li>
                @empty
                    <li class="text-gray-500">Aucune interaction enregistree.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Opportunites</h2>
            <ul class="divide-y">
                @forelse ($client->opportunites as $opportunite)
                    <li class="py-2 flex justify-between">
                        <a href="{{ route('opportunites.show', $opportunite) }}" class="text-blue-600 hover:underline">
                            {{ $opportunite->titre }}
                        </a>
                        <span>{{ number_format($opportunite->montant, 2) }} — {{ ucfirst($opportunite->etape) }}</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">Aucune opportunite.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Reclamations</h2>
            <ul class="divide-y">
                @forelse ($client->reclamations as $reclamation)
                    <li class="py-2 flex justify-between">
                        <a href="{{ route('reclamations.show', $reclamation) }}" class="text-blue-600 hover:underline">
                            {{ $reclamation->sujet }}
                        </a>
                        <span>{{ ucfirst($reclamation->statut) }}</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">Aucune reclamation.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
