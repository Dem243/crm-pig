<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInteractionRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;

class InteractionController extends Controller
{
    public function store(StoreInteractionRequest $request, Client $client): RedirectResponse
    {
        $this->authorize('view', $client);

        $client->interactions()->create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('clients.show', $client)
            ->with('succes', 'Interaction enregistree.');
    }

    public function destroy(Client $client, \App\Models\Interaction $interaction): RedirectResponse
    {
        $this->authorize('update', $client);

        $interaction->delete();

        return redirect()
            ->route('clients.show', $client)
            ->with('succes', 'Interaction supprimee.');
    }
}
