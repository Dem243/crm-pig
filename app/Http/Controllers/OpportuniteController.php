<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOpportuniteRequest;
use App\Models\Client;
use App\Models\Opportunite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OpportuniteController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Opportunite::class);

        $query = Opportunite::with(['client', 'commercial']);

        if ($request->user()->hasRole('commercial')) {
            $query->where('commercial_id', $request->user()->id);
        }

        $opportunites = $query->get()->groupBy('etape');

        return view('opportunites.index', [
            'opportunitesParEtape' => $opportunites,
            'etapes' => Opportunite::ETAPES,
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Opportunite::class);

        $clients = Client::orderBy('nom')->get();
        $commerciaux = User::whereHas('role', fn ($q) => $q->where('nom', 'commercial'))->get();

        return view('opportunites.create', compact('clients', 'commerciaux'));
    }

    public function store(StoreOpportuniteRequest $request): RedirectResponse
    {
        $this->authorize('create', Opportunite::class);

        $opportunite = Opportunite::create($request->validated());

        return redirect()
            ->route('opportunites.show', $opportunite)
            ->with('succes', 'Opportunite creee.');
    }

    public function show(Opportunite $opportunite): View
    {
        $this->authorize('view', $opportunite);

        $opportunite->load('client', 'commercial');

        return view('opportunites.show', compact('opportunite'));
    }

    public function update(StoreOpportuniteRequest $request, Opportunite $opportunite): RedirectResponse
    {
        $this->authorize('update', $opportunite);

        $opportunite->update($request->validated());

        return redirect()
            ->route('opportunites.show', $opportunite)
            ->with('succes', 'Opportunite mise a jour.');
    }

    /**
     * Mise a jour rapide de l'etape (utilisee par le glisser-deposer du kanban).
     */
    public function changerEtape(Request $request, Opportunite $opportunite): JsonResponse
    {
        $this->authorize('update', $opportunite);

        $request->validate([
            'etape' => 'required|in:' . implode(',', Opportunite::ETAPES),
        ]);

        $opportunite->update(['etape' => $request->string('etape')]);

        return response()->json(['succes' => true]);
    }

    public function destroy(Opportunite $opportunite): RedirectResponse
    {
        $this->authorize('delete', $opportunite);

        $opportunite->delete();

        return redirect()
            ->route('opportunites.index')
            ->with('succes', 'Opportunite supprimee.');
    }
}
