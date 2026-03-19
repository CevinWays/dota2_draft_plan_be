<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftPlanEnemyThreat\StoreDraftPlanEnemyThreatRequest;
use App\Http\Requests\DraftPlanEnemyThreat\UpdateDraftPlanEnemyThreatRequest;
use Illuminate\Http\Request;

class DraftPlanEnemyThreatController extends Controller
{
    public function index(Request $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        
        return response()->json([
            'data' => $draftPlan->enemyThreats()->with('hero')->orderBy('sort_order')->get()
        ]);
    }

    public function store(StoreDraftPlanEnemyThreatRequest $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $heroIds = $request->input('hero_ids');
        $createdRecords = [];

        foreach ($heroIds as $heroId) {
            $record = $draftPlan->enemyThreats()->create([
                'hero_id' => $heroId,
                'note' => $request->input('note'),
                'threat_level' => $request->input('threat_level'),
                'sort_order' => $request->input('sort_order'),
            ]);
            $createdRecords[] = $record->load('hero');
        }

        return response()->json([
            'data' => $createdRecords
        ], 201);
    }

    public function update(UpdateDraftPlanEnemyThreatRequest $request, $id, $threatId)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $threat = $draftPlan->enemyThreats()->findOrFail($threatId);
        $threat->update($request->validated());

        return response()->json([
            'data' => $threat->load('hero')
        ]);
    }

    public function destroy(Request $request, $id, $threatId)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $threat = $draftPlan->enemyThreats()->findOrFail($threatId);
        $threat->delete();

        return response()->json(null, 204);
    }
}
