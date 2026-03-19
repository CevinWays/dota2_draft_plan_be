<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftPlanItemTiming extends Model
{
    use HasFactory;

    protected $fillable = [
        'draft_plan_id',
        'minute_mark',
        'item_name',
        'note',
        'sort_order',
    ];

    public function draftPlan()
    {
        return $this->belongsTo(DraftPlan::class);
    }
}
