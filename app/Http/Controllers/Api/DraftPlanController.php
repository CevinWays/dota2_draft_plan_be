<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftPlan\StoreDraftPlanRequest;
use App\Http\Requests\DraftPlan\UpdateDraftPlanRequest;
use App\Models\DraftPlan;
use App\Models\DraftPlanBan;
use App\Models\DraftPlanPreferredPick;
use App\Models\DraftPlanEnemyThreat;
use App\Models\DraftPlanItemTiming;
use Illuminate\Http\Request;

class DraftPlanController extends Controller
{
    public function index(Request $request)
    {
        $draftPlans = $request->user()->draftPlans()->get();

        return response()->json([
            'data' => $draftPlans
        ]);
    }

    public function store(StoreDraftPlanRequest $request)
    {
        $draftPlan = $request->user()->draftPlans()->create($request->validated());

        return response()->json([
            'data' => $draftPlan
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $draftPlanBanHero = DraftPlanBan::where('draft_plan_id', $id)->get();
        $draftPlanPreferredPick = DraftPlanPreferredPick::where('draft_plan_id', $id)->get();
        $draftPlanEnemyThreat = DraftPlanEnemyThreat::where('draft_plan_id', $id)->get();
        $draftPlanItemTiming = DraftPlanItemTiming::where('draft_plan_id', $id)->get();

        return response()->json([
            'data' => $draftPlan,
            'bans' => $draftPlanBanHero,
            'preferredPicks' => $draftPlanPreferredPick,
            'enemyThreats' => $draftPlanEnemyThreat,
            'itemTimings' => $draftPlanItemTiming,
        ]);
    }

    public function update(UpdateDraftPlanRequest $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $draftPlan->update($request->validated());

        return response()->json([
            'data' => $draftPlan
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $draftPlan->delete();

        return response()->json(null, 204);
    }

    public function summary(Request $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()
            ->with(['bans.hero', 'preferredPicks.hero', 'enemyThreats.hero', 'itemTimings'])
            ->findOrFail($id);

        return response()->json([
            'data' => $draftPlan
        ]);
    }
}
