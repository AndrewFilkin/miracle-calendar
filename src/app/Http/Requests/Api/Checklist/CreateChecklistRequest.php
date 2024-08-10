<?php

namespace App\Http\Requests\Api\Checklist;

use App\Rules\MatchArrayLengths;
use Illuminate\Foundation\Http\FormRequest;

class CreateChecklistRequest extends FormRequest
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
            'text' => 'required|array',
            'text.*' => 'required|string|min:3|max:500',
            'is_selected' => ['required', 'array', new MatchArrayLengths],
            'is_selected.*' => 'required|boolean',
        ];
    }
}
