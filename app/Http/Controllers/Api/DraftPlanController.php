<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftPlan\StoreDraftPlanRequest;
use App\Http\Requests\DraftPlan\UpdateDraftPlanRequest;
use App\Models\DraftPlan;
use Illuminate\Http\Request;

class DraftPlanController extends Controller
{
    public function index(Request $request)
    {
        $draftPlans = $request->user()->draftPlans()
            ->withCount(['bans', 'preferredPicks', 'enemyThreats'])
            ->get()
            ->map(function ($draftPlan) {
                $draftPlan->count_ban_hero = $draftPlan->bans_count;
                $draftPlan->count_prefered_pick_hero = $draftPlan->preferred_picks_count;
                $draftPlan->count_enemy_threat_hero = $draftPlan->enemy_threats_count;
                unset($draftPlan->bans_count, $draftPlan->preferred_picks_count, $draftPlan->enemy_threats_count);
                return $draftPlan;
            });

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

        return response()->json([
            'data' => $draftPlan,
            'bans' => $draftPlan->bans()->with('hero')->get(),
            'preferredPicks' => $draftPlan->preferredPicks()->with('hero')->get(),
            'enemyThreats' => $draftPlan->enemyThreats()->with('hero')->get(),
            'itemTimings' => $draftPlan->itemTimings()->get(),
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
