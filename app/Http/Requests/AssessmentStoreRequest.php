<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssessmentStoreRequest extends FormRequest
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
            'students' => 'required|array|min:1',
            'students.*.assessment_files' => 'required|array|min:1',
            'students.*.assessment_files.*' => 'file|mimetypes:image/*,application/pdf',
            'llm_model' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'students.required' => 'At least one student group must be added.',
            'students.min' => 'At least one student group must be added.',
            'students.*.assessment_files.required' => 'Assessment files are required for each student group.',
            'students.*.assessment_files.min' => 'At least one assessment file is required for each student group.',
            'students.*.assessment_files.*.file' => 'Each file must be a valid file.',
            'students.*.assessment_files.*.mimetypes' => 'Files must be images or PDFs.',
        ];
    }
}
