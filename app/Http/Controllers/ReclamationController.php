<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReclamationRequest;
use App\Models\Client;
use App\Models\Reclamation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReclamationController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Reclamation::class);

        $query = Reclamation::with(['client', 'agent'])->latest();

        if ($request->user()->hasRole('commercial')) {
            $query->where('assigned_to', $request->user()->id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->string('statut'));
        }

        $reclamations = $query->paginate(15)->withQueryString();

        return view('reclamations.index', compact('reclamations'));
    }

    public function create(): View
    {
        $this->authorize('create', Reclamation::class);

        $clients = Client::orderBy('nom')->get();
        $agents = User::whereHas('role', fn ($q) => $q->whereIn('nom', ['manager', 'commercial']))->get();

        return view('reclamations.create', compact('clients', 'agents'));
    }

    public function store(StoreReclamationRequest $request): RedirectResponse
    {
        $this->authorize('create', Reclamation::class);

        $reclamation = Reclamation::create($request->validated());

        return redirect()
            ->route('reclamations.show', $reclamation)
            ->with('succes', 'Reclamation enregistree.');
    }

    public function show(Reclamation $reclamation): View
    {
        $this->authorize('view', $reclamation);

        $reclamation->load('client', 'agent');

        return view('reclamations.show', compact('reclamation'));
    }

    public function update(StoreReclamationRequest $request, Reclamation $reclamation): RedirectResponse
    {
        $this->authorize('update', $reclamation);

        $data = $request->validated();

        if ($data['statut'] === 'resolue' && ! $reclamation->date_resolution) {
            $data['date_resolution'] = now();
        }

        $reclamation->update($data);

        return redirect()
            ->route('reclamations.show', $reclamation)
            ->with('succes', 'Reclamation mise a jour.');
    }

    public function destroy(Reclamation $reclamation): RedirectResponse
    {
        $this->authorize('delete', $reclamation);

        $reclamation->delete();

        return redirect()
            ->route('reclamations.index')
            ->with('succes', 'Reclamation supprimee.');
    }
}
