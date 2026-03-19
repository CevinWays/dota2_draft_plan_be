<?php

namespace App\Http\Requests\DraftPlanBan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDraftPlanBanRequest extends FormRequest
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
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
