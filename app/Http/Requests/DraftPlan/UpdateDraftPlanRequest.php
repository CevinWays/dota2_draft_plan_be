<?php

namespace App\Http\Requests\DraftPlan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDraftPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('id')->user_id === $this->user()->id; // Will handle in controller or policy
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'patch_version' => ['nullable', 'string', 'max:50'],
            'strategy_notes' => ['nullable', 'string'],
        ];
    }
}
