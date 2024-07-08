<?php

namespace App\Http\Requests\Api\Task;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'start_date' => 'date_format:Y-m-d H:i',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_completed' => 'boolean',
            'is_urgently' => 'boolean',
            'participant.*' => 'numeric|exists:users,id',
        ];
    }
}
