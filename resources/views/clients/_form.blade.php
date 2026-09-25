@php $c = $client; @endphp

<div>
    <label class="block text-sm font-medium mb-1">Type</label>
    <select name="type" class="w-full border rounded px-3 py-2">
        <option value="prospect" @selected(old('type', $c->type ?? 'prospect') === 'prospect')>Prospect</option>
        <option value="client" @selected(old('type', $c->type ?? '') === 'client')>Client</option>
    </select>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $c->nom ?? '') }}" class="w-full border rounded px-3 py-2" required>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Entreprise</label>
    <input type="text" name="entreprise" value="{{ old('entreprise', $c->entreprise ?? '') }}" class="w-full border rounded px-3 py-2">
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $c->email ?? '') }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Telephone</label>
        <input type="text" name="telephone" value="{{ old('telephone', $c->telephone ?? '') }}" class="w-full border rounded px-3 py-2">
    </div>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Adresse</label>
    <textarea name="adresse" class="w-full border rounded px-3 py-2" rows="2">{{ old('adresse', $c->adresse ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Source</label>
        <input type="text" name="source" value="{{ old('source', $c->source ?? '') }}" placeholder="site web, salon, ..." class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Statut</label>
        <select name="statut" class="w-full border rounded px-3 py-2">
            <option value="actif" @selected(old('statut', $c->statut ?? 'actif') === 'actif')>Actif</option>
            <option value="inactif" @selected(old('statut', $c->statut ?? '') === 'inactif')>Inactif</option>
        </select>
    </div>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Commercial assigne</label>
    <select name="commercial_id" class="w-full border rounded px-3 py-2">
        <option value="">— Aucun —</option>
        @foreach ($commerciaux as $commercial)
            <option value="{{ $commercial->id }}" @selected((string) old('commercial_id', $c->commercial_id ?? '') === (string) $commercial->id)>
                {{ $commercial->name }}
            </option>
        @endforeach
    </select>
</div>

@error('nom') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
