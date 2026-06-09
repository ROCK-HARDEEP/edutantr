<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesTeam extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'daily_target' => 'float',
        'is_active' => 'boolean',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(SalesTeamMember::class);
    }

    public function activeMembers(): HasMany
    {
        return $this->hasMany(SalesTeamMember::class)->where('is_active', true);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function leader(): HasMany
    {
        return $this->hasMany(SalesTeamMember::class)->where('is_leader', true);
    }
}
