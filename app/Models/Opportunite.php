<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opportunite extends Model
{
    use HasFactory;

    public const ETAPES = [
        'prospection', 'qualification', 'proposition', 'negociation', 'gagne', 'perdu',
    ];

    protected $fillable = [
        'client_id',
        'commercial_id',
        'titre',
        'montant',
        'etape',
        'probabilite',
        'date_cloture_prevue',
    ];

    protected function casts(): array
    {
        return [
            'montant' => 'decimal:2',
            'date_cloture_prevue' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function commercial(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commercial_id');
    }

    public function estGagnee(): bool
    {
        return $this->etape === 'gagne';
    }

    public function estPerdue(): bool
    {
        return $this->etape === 'perdu';
    }
}
