<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentStoreRequest extends FormRequest
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
            'question_text'   => ['required_without:questions', 'string'],
            
            'questions'       => ['required_without:question_text', 'array'],
            'questions.*'     => ['file', 'mimes:jpeg,png,jpg,pdf'],
            'max_total'       => ['required', 'integer'],
        ];
    }
}
