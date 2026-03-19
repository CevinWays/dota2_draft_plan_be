<?php

namespace App\Http\Requests\DraftPlanPreferredPick;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDraftPlanPreferredPickRequest extends FormRequest
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
            'priority' => ['nullable', 'integer'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
