<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reclamation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'assigned_to',
        'sujet',
        'description',
        'statut',
        'priorite',
        'date_resolution',
    ];

    protected function casts(): array
    {
        return [
            'date_resolution' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function estOuverte(): bool
    {
        return in_array($this->statut, ['ouverte', 'en_cours'], true);
    }
}
