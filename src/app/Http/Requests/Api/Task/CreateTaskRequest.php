<?php

namespace App\Http\Requests\Api\Task;

use App\Rules\MatchArrayLengths;
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
            'start_date' => 'required|date_format:Y-m-d H:i',
            'end_date' => 'required|nullable|date_format:Y-m-d H:i|after_or_equal:start_date',
            'is_completed' => 'boolean',
            'is_urgently' => 'boolean',
            'comment' => 'string|max:1000',
            'files*' => 'file|max:50000',
            'participant.*' => 'numeric|exists:users,id',
            //create Checklist
            'text' => 'required|array',
            'text.*' => 'required|string|min:3|max:500',
            'is_selected' => ['required', 'array', new MatchArrayLengths],
            'is_selected.*' => 'required|boolean',
        ];
    }
}
