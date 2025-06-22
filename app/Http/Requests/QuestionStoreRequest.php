<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionStoreRequest extends FormRequest
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
            'question_text'   => ['required_without:question_file'],
            'question_file'       => ['required_without:question_text', 'file:pdf,image'],
            'max_total'       => ['required', 'integer'],
            'difficulty'      => ['required', 'string'],
            'course_code'     => ['required', 'string'],
            'session'         => ['required', 'string'],
            'semester'        => ['required', 'string'],
            'level'           => ['required', 'string'],
            'answer_file'     => ['nullable', 'file:pdf,image'],
        ];
    }
}
