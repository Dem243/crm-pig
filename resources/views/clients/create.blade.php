@extends('layouts.app')

@section('titre', 'Nouveau client')

@section('contenu')
<h1 class="text-2xl font-semibold mb-6">Nouveau client / prospect</h1>

<form method="POST" action="{{ route('clients.store') }}" class="bg-white rounded shadow p-6 max-w-2xl space-y-4">
    @csrf
    @include('clients._form', ['client' => null])

    <div class="flex justify-end gap-3">
        <a href="{{ route('clients.index') }}" class="px-4 py-2 rounded border">Annuler</a>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
    </div>
</form>
@endsection
