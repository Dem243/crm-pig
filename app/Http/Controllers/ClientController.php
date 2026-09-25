<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Client::class);

        $query = Client::with('commercial')->latest();

        // Un commercial ne voit que ses propres clients, admin/manager voient tout
        if ($request->user()->hasRole('commercial')) {
            $query->where('commercial_id', $request->user()->id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        if ($request->filled('recherche')) {
            $recherche = $request->string('recherche');
            $query->where(function ($q) use ($recherche) {
                $q->where('nom', 'like', "%{$recherche}%")
                    ->orWhere('entreprise', 'like', "%{$recherche}%")
                    ->orWhere('email', 'like', "%{$recherche}%");
            });
        }

        $clients = $query->paginate(15)->withQueryString();

        return view('clients.index', compact('clients'));
    }

    public function create(): View
    {
        $this->authorize('create', Client::class);

        $commerciaux = User::whereHas('role', fn ($q) => $q->where('nom', 'commercial'))->get();

        return view('clients.create', compact('commerciaux'));
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $this->authorize('create', Client::class);

        $client = Client::create($request->validated());

        return redirect()
            ->route('clients.show', $client)
            ->with('succes', 'Client cree avec succes.');
    }

    public function show(Client $client): View
    {
        $this->authorize('view', $client);

        $client->load(['interactions.user', 'opportunites', 'reclamations']);

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        $this->authorize('update', $client);

        $commerciaux = User::whereHas('role', fn ($q) => $q->where('nom', 'commercial'))->get();

        return view('clients.edit', compact('client', 'commerciaux'));
    }

    public function update(StoreClientRequest $request, Client $client): RedirectResponse
    {
        $this->authorize('update', $client);

        $client->update($request->validated());

        return redirect()
            ->route('clients.show', $client)
            ->with('succes', 'Client mis a jour.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->authorize('delete', $client);

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('succes', 'Client supprime.');
    }
}
