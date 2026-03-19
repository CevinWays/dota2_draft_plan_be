# Planning: Enhance API Endpoints for Multiple Hero Support

This plan outlines the steps required to enhance the `draft_plan_bans`, `draft_plan_preferred_picks`, and `draft_plan_enemy_threats` endpoints to support bulk creation of records by sending an array of `hero_ids`.

## 1. Objectives
- Modify the `store` endpoints for draft plan bans, preferred picks, and enemy threats.
- Allow the client to send an array of `hero_ids`.
- Create multiple records on the server based on the provided array.
- Return all newly created records in the response.

## 2. Affected Components

### 2.1 Validation (Form Requests)
Update the following request classes to expect `hero_ids` as a required array of existing hero IDs:
- `App\Http\Requests\DraftPlanBan\StoreDraftPlanBanRequest`
- `App\Http\Requests\DraftPlanPreferredPick\StoreDraftPlanPreferredPickRequest`
- `App\Http\Requests\DraftPlanEnemyThreat\StoreDraftPlanEnemyThreatRequest`

### 2.2 Controllers
Update the `store` methods in the following controllers to handle multiple record creation:
- `App\Http\Controllers\Api\DraftPlanBanController`
- `App\Http\Controllers\Api\DraftPlanPreferredPickController`
- `App\Http\Controllers\Api\DraftPlanEnemyThreatController`

## 3. Implementation Details

### 3.1 Form Request Changes
The `rules()` method in the affected request classes will be updated as follows:
```php
public function rules(): array
{
    return [
        'hero_ids' => ['required', 'array'],
        'hero_ids.*' => ['required', 'exists:heroes,id'],
        'note' => ['nullable', 'string'],
        'sort_order' => ['nullable', 'integer'],
    ];
}
```

### 3.2 Controller Changes
The `store` method will be updated to:
1. Extract `hero_ids`.
2. Iterate through each `hero_id` and create a record.
3. Collect all created records.
4. Return the collection in the JSON response.

Example implementation for `DraftPlanBanController`:
```php
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
```

## 4. Verification Plan
- **Test `draft_plan_bans`**: Send `{"hero_ids": [1, 2, 3]}` to `POST /api/draft-plans/{id}/bans` and verify three records are created and returned.
- **Test `draft_plan_preferred_picks`**: Send `{"hero_ids": [4, 5]}` to `POST /api/draft-plans/{id}/preferred-picks` and verify two records are created and returned.
- **Test `draft_plan_enemy_threats`**: Send `{"hero_ids": [6]}` to `POST /api/draft-plans/{id}/enemy-threats` and verify one record is created and returned.
- **Validate Error Handling**: Ensure sending an empty array or non-existent hero IDs returns a validation error.
