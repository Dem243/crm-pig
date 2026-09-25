@extends('layouts.app')

@section('titre', 'Modifier client')

@section('contenu')
<h1 class="text-2xl font-semibold mb-6">Modifier {{ $client->nom }}</h1>

<form method="POST" action="{{ route('clients.update', $client) }}" class="bg-white rounded shadow p-6 max-w-2xl space-y-4">
    @csrf
    @method('PUT')
    @include('clients._form', ['client' => $client])

    <div class="flex justify-end gap-3">
        <a href="{{ route('clients.show', $client) }}" class="px-4 py-2 rounded border">Annuler</a>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mettre a jour</button>
    </div>
</form>
@endsection
