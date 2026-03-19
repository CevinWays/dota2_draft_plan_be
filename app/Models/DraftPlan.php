<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'patch_version',
        'strategy_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bans()
    {
        return $this->hasMany(DraftPlanBan::class);
    }

    public function preferredPicks()
    {
        return $this->hasMany(DraftPlanPreferredPick::class);
    }

    public function enemyThreats()
    {
        return $this->hasMany(DraftPlanEnemyThreat::class);
    }

    public function itemTimings()
    {
        return $this->hasMany(DraftPlanItemTiming::class);
    }
}
