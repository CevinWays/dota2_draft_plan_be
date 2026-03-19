<?php

namespace App\Http\Requests\DraftPlanEnemyThreat;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDraftPlanEnemyThreatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hero_id' => ['sometimes', 'required', 'exists:heroes,id'],
            'note' => ['nullable', 'string'],
            'threat_level' => ['nullable', 'integer'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
