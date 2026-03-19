<?php

namespace App\Http\Requests\DraftPlanEnemyThreat;

use Illuminate\Foundation\Http\FormRequest;

class StoreDraftPlanEnemyThreatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hero_ids' => ['required', 'array'],
            'hero_ids.*' => ['required', 'exists:heroes,id'],
            'note' => ['nullable', 'string'],
            'threat_level' => ['nullable', 'integer'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
