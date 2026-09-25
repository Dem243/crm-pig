@extends('layouts.app')

@section('titre', $opportunite->titre)

@section('contenu')
<h1 class="text-2xl font-semibold mb-6">{{ $opportunite->titre }}</h1>

<div class="bg-white rounded shadow p-6 max-w-2xl space-y-3 text-sm">
    <p><strong>Client :</strong> <a href="{{ route('clients.show', $opportunite->client) }}" class="text-blue-600 hover:underline">{{ $opportunite->client->nom }}</a></p>
    <p><strong>Commercial :</strong> {{ $opportunite->commercial->name }}</p>
    <p><strong>Montant :</strong> {{ number_format($opportunite->montant, 2) }}</p>
    <p><strong>Etape :</strong> {{ ucfirst($opportunite->etape) }}</p>
    <p><strong>Probabilite :</strong> {{ $opportunite->probabilite }}%</p>
    <p><strong>Cloture prevue :</strong> {{ optional($opportunite->date_cloture_prevue)->format('d/m/Y') ?? '—' }}</p>
</div>
@endsection
