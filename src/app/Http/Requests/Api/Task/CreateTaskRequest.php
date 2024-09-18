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
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'start_date' => 'required|date_format:Y-m-d H:i',
            'end_date' => 'required|nullable|date_format:Y-m-d H:i|after_or_equal:start_date',
            'is_completed' => 'boolean',
            'is_urgently' => 'boolean',
            'comment' => 'string|max:1000',
            'files*' => 'file|max:50000|mimes:jpg,png,pdf,docx,scv,txt,doc,xls,ppt,rtf,tiff,mp4,mp3,mkv,avi,mov,xml',
            'participant.*' => 'numeric|exists:users,id',
            //create Checklist
            'text' => 'array',
            'text.*' => 'string|min:3|max:500',
            'is_selected' => ['array', new MatchArrayLengths],
            'is_selected.*' => 'boolean',
        ];
    }
}
