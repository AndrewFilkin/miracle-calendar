<?php

namespace App\Http\Requests\Api\Checklist;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChecklistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task_id' => 'required|exists:tasks,id',
            'checklist_id' => 'required|exists:checklists,id',
            'is_selected' => 'required|boolean',
            'text' => 'string|min:3|max:100',
        ];
    }
}
