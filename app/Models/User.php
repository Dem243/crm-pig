<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string ...$noms): bool
    {
        return $this->role && in_array($this->role->nom, $noms, true);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'commercial_id');
    }

    public function opportunites(): HasMany
    {
        return $this->hasMany(Opportunite::class, 'commercial_id');
    }

    public function reclamationsAssignees(): HasMany
    {
        return $this->hasMany(Reclamation::class, 'assigned_to');
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }
}
