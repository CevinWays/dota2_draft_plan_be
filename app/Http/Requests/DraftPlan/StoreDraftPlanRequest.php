<?php

namespace App\Http\Requests\DraftPlan;

use Illuminate\Foundation\Http\FormRequest;

class StoreDraftPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'patch_version' => ['nullable', 'string', 'max:50'],
            'strategy_notes' => ['nullable', 'string'],
        ];
    }
}
