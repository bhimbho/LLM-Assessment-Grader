<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentStoreRequest extends FormRequest
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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'othername' => ['nullable', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:255', 'unique:students,student_id'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'firstname.required' => 'First name is required.',
            'firstname.string' => 'First name must be a string.',
            'firstname.max' => 'First name may not be greater than 255 characters.',
            
            'lastname.required' => 'Last name is required.',
            'lastname.string' => 'Last name must be a string.',
            'lastname.max' => 'Last name may not be greater than 255 characters.',
            
            'othername.string' => 'Other name must be a string.',
            'othername.max' => 'Other name may not be greater than 255 characters.',
            
            'student_id.required' => 'Student ID is required.',
            'student_id.string' => 'Student ID must be a string.',
            'student_id.max' => 'Student ID may not be greater than 255 characters.',
            'student_id.unique' => 'This Student ID already exists.',
            
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email may not be greater than 255 characters.',
            'email.unique' => 'This email address is already registered.',
        ];
    }
}
