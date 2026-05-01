<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'expected_salary' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:open,closed,paused'],
        ];
    }
}
