<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftPlanBan\StoreDraftPlanBanRequest;
use App\Http\Requests\DraftPlanBan\UpdateDraftPlanBanRequest;
use Illuminate\Http\Request;

class DraftPlanBanController extends Controller
{
    public function index(Request $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        
        return response()->json([
            'data' => $draftPlan->bans()->with('hero')->orderBy('sort_order')->get()
        ]);
    }

    public function store(StoreDraftPlanBanRequest $request, $id)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $heroIds = $request->input('hero_ids');
        $createdRecords = [];

        foreach ($heroIds as $heroId) {
            $record = $draftPlan->bans()->create([
                'hero_id' => $heroId,
                'note' => $request->input('note'),
                'sort_order' => $request->input('sort_order'),
            ]);
            $createdRecords[] = $record->load('hero');
        }

        return response()->json([
            'data' => $createdRecords
        ], 201);
    }

    public function update(UpdateDraftPlanBanRequest $request, $id, $banId)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $ban = $draftPlan->bans()->findOrFail($banId);
        $ban->update($request->validated());

        return response()->json([
            'data' => $ban->load('hero')
        ]);
    }

    public function destroy(Request $request, $id, $banId)
    {
        $draftPlan = $request->user()->draftPlans()->findOrFail($id);
        $ban = $draftPlan->bans()->findOrFail($banId);
        $ban->delete();

        return response()->json(null, 204);
    }
}
