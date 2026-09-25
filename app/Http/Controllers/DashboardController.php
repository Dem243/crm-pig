<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Opportunite;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $estCommercial = $user->hasRole('commercial');

        $opportunitesQuery = Opportunite::query();
        $reclamationsQuery = Reclamation::query();
        $clientsQuery = Client::query();

        if ($estCommercial) {
            $opportunitesQuery->where('commercial_id', $user->id);
            $reclamationsQuery->where('assigned_to', $user->id);
            $clientsQuery->where('commercial_id', $user->id);
        }

        $caPrevisionnel = (clone $opportunitesQuery)
            ->whereNotIn('etape', ['gagne', 'perdu'])
            ->sum('montant');

        $caGagne = (clone $opportunitesQuery)->where('etape', 'gagne')->sum('montant');

        $totalOpportunites = (clone $opportunitesQuery)->count();
        $opportunitesGagnees = (clone $opportunitesQuery)->where('etape', 'gagne')->count();
        $tauxConversion = $totalOpportunites > 0
            ? round($opportunitesGagnees / $totalOpportunites * 100, 1)
            : 0;

        $reclamationsOuvertes = (clone $reclamationsQuery)
            ->whereIn('statut', ['ouverte', 'en_cours'])
            ->count();

        $nombreClients = (clone $clientsQuery)->where('type', 'client')->count();
        $nombreProspects = (clone $clientsQuery)->where('type', 'prospect')->count();

        $dernieresInteractions = \App\Models\Interaction::with('client', 'user')
            ->when($estCommercial, fn ($q) => $q->where('user_id', $user->id))
            ->latest('date_interaction')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'caPrevisionnel',
            'caGagne',
            'tauxConversion',
            'reclamationsOuvertes',
            'nombreClients',
            'nombreProspects',
            'dernieresInteractions'
        ));
    }
}
