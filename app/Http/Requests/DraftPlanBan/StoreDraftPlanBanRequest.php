<?php

namespace App\Http\Requests\DraftPlanBan;

use Illuminate\Foundation\Http\FormRequest;

class StoreDraftPlanBanRequest extends FormRequest
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
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
