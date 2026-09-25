@extends('layouts.app')

@section('titre', 'Tableau de bord')

@section('contenu')
<h1 class="text-2xl font-semibold mb-6">Tableau de bord</h1>

<div class="grid grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded shadow p-4">
        <p class="text-sm text-gray-500">CA previsionnel</p>
        <p class="text-2xl font-bold">{{ number_format($caPrevisionnel, 2) }}</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <p class="text-sm text-gray-500">CA gagne</p>
        <p class="text-2xl font-bold text-green-600">{{ number_format($caGagne, 2) }}</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <p class="text-sm text-gray-500">Taux de conversion</p>
        <p class="text-2xl font-bold">{{ $tauxConversion }}%</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <p class="text-sm text-gray-500">Reclamations ouvertes</p>
        <p class="text-2xl font-bold text-red-600">{{ $reclamationsOuvertes }}</p>
    </div>
</div>

<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded shadow p-4">
        <p class="text-sm text-gray-500">Clients actifs</p>
        <p class="text-xl font-semibold">{{ $nombreClients }}</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <p class="text-sm text-gray-500">Prospects</p>
        <p class="text-xl font-semibold">{{ $nombreProspects }}</p>
    </div>
</div>

<div class="bg-white rounded shadow p-4">
    <h2 class="font-semibold mb-3">Dernieres interactions</h2>
    <ul class="divide-y text-sm">
        @forelse ($dernieresInteractions as $interaction)
            <li class="py-2 flex justify-between">
                <span>{{ ucfirst($interaction->type) }} — {{ $interaction->client->nom }} ({{ $interaction->user->name }})</span>
                <span class="text-gray-500">{{ $interaction->date_interaction->format('d/m/Y H:i') }}</span>
            </li>
        @empty
            <li class="py-2 text-gray-500">Aucune interaction recente.</li>
        @endforelse
    </ul>
</div>
@endsection
