<?php

namespace App\Http\Requests\DraftPlanPreferredPick;

use Illuminate\Foundation\Http\FormRequest;

class StoreDraftPlanPreferredPickRequest extends FormRequest
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
            'priority' => ['nullable', 'integer'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
