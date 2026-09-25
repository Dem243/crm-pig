@extends('layouts.app')

@section('titre', 'Opportunites')

@section('contenu')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Pipeline des opportunites</h1>
    <a href="{{ route('opportunites.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Nouvelle opportunite
    </a>
</div>

<div
    x-data="{
        colonneSurvolee: null,
        deplacer(event, opportuniteId, nouvelleEtape) {
            event.preventDefault();
            this.colonneSurvolee = null;
            fetch(`/opportunites/${opportuniteId}/etape`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: JSON.stringify({ etape: nouvelleEtape }),
            }).then(() => window.location.reload());
        }
    }"
    class="grid grid-cols-6 gap-4 overflow-x-auto"
>
    @foreach ($etapes as $etape)
        <div
            class="bg-gray-100 rounded p-3 min-h-[300px]"
            :class="colonneSurvolee === '{{ $etape }}' ? 'ring-2 ring-blue-400' : ''"
            @dragover.prevent="colonneSurvolee = '{{ $etape }}'"
            @dragleave="colonneSurvolee = null"
            @drop="(e) => deplacer(e, e.dataTransfer.getData('text/plain'), '{{ $etape }}')"
        >
            <h2 class="font-semibold text-sm mb-3 uppercase text-gray-600">
                {{ str_replace('_', ' ', $etape) }}
                <span class="text-gray-400">({{ ($opportunitesParEtape[$etape] ?? collect())->count() }})</span>
            </h2>

            <div class="space-y-2">
                @foreach (($opportunitesParEtape[$etape] ?? []) as $opportunite)
                    <div
                        draggable="true"
                        @dragstart="(e) => e.dataTransfer.setData('text/plain', '{{ $opportunite->id }}')"
                        class="bg-white rounded shadow p-3 cursor-move text-sm"
                    >
                        <a href="{{ route('opportunites.show', $opportunite) }}" class="font-medium text-blue-600 hover:underline">
                            {{ $opportunite->titre }}
                        </a>
                        <p class="text-gray-500">{{ $opportunite->client->nom }}</p>
                        <p class="font-semibold">{{ number_format($opportunite->montant, 2) }}</p>
                        <p class="text-xs text-gray-400">{{ $opportunite->probabilite }}% de chance</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
