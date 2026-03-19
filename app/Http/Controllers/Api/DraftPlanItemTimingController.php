<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftPlanItemTiming\StoreDraftPlanItemTimingRequest;
use App\Http\Requests\DraftPlanItemTiming\UpdateDraftPlanItemTimingRequest;
use Illuminate\Http\Request;

class DraftPlanItemTimingController extends Controller
{
    public function index(Request $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        
        return response()->json([
            'data' => $draftPlan->itemTimings()->orderBy('sort_order')->get()
        ]);
    }

    public function store(StoreDraftPlanItemTimingRequest $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $timing = $draftPlan->itemTimings()->create($request->validated());

        return response()->json([
            'data' => $timing
        ], 201);
    }

    public function update(UpdateDraftPlanItemTimingRequest $request, $id, $timingId)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $timing = $draftPlan->itemTimings()->findOrFail($timingId);
        $timing->update($request->validated());

        return response()->json([
            'data' => $timing
        ]);
    }

    public function destroy(Request $request, $id, $timingId)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $timing = $draftPlan->itemTimings()->findOrFail($timingId);
        $timing->delete();

        return response()->json(null, 204);
    }
}
