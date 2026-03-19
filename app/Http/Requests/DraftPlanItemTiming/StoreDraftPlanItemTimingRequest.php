<?php

namespace App\Http\Requests\DraftPlanItemTiming;

use Illuminate\Foundation\Http\FormRequest;

class StoreDraftPlanItemTimingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'minute_mark' => ['nullable', 'integer'],
            'item_name' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
