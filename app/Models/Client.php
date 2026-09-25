<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'nom',
        'entreprise',
        'email',
        'telephone',
        'adresse',
        'source',
        'statut',
        'commercial_id',
    ];

    public function commercial(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commercial_id');
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class)->latest('date_interaction');
    }

    public function opportunites(): HasMany
    {
        return $this->hasMany(Opportunite::class);
    }

    public function reclamations(): HasMany
    {
        return $this->hasMany(Reclamation::class);
    }

    public function scopeProspects($query)
    {
        return $query->where('type', 'prospect');
    }

    public function scopeClientsActifs($query)
    {
        return $query->where('type', 'client')->where('statut', 'actif');
    }
}
