<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftPlanPreferredPick\StoreDraftPlanPreferredPickRequest;
use App\Http\Requests\DraftPlanPreferredPick\UpdateDraftPlanPreferredPickRequest;
use Illuminate\Http\Request;

class DraftPlanPreferredPickController extends Controller
{
    public function index(Request $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        
        return response()->json([
            'data' => $draftPlan->preferredPicks()->with('hero')->orderBy('sort_order')->get()
        ]);
    }

    public function store(StoreDraftPlanPreferredPickRequest $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $heroIds = $request->input('hero_ids');
        $createdRecords = [];

        foreach ($heroIds as $heroId) {
            $record = $draftPlan->preferredPicks()->create([
                'hero_id' => $heroId,
                'note' => $request->input('note'),
                'priority' => $request->input('priority'),
                'sort_order' => $request->input('sort_order'),
            ]);
            $createdRecords[] = $record->load('hero');
        }

        return response()->json([
            'data' => $createdRecords
        ], 201);
    }

    public function update(UpdateDraftPlanPreferredPickRequest $request, $id, $pickId)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $pick = $draftPlan->preferredPicks()->findOrFail($pickId);
        $pick->update($request->validated());

        return response()->json([
            'data' => $pick->load('hero')
        ]);
    }

    public function destroy(Request $request, $id, $pickId)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $pick = $draftPlan->preferredPicks()->findOrFail($pickId);
        $pick->delete();

        return response()->json(null, 204);
    }
}
