<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftPlanBan extends Model
{
    use HasFactory;

    protected $fillable = [
        'draft_plan_id',
        'hero_id',
        'note',
        'sort_order',
    ];

    public function draftPlan()
    {
        return $this->belongsTo(DraftPlan::class);
    }

    public function hero()
    {
        return $this->belongsTo(Hero::class);
    }
}
