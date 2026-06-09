<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => __('Please select a CSV file to import.'),
            'file.mimes' => __('The import file must be a CSV file.'),
            'file.max' => __('The import file may not be greater than 5MB.'),
        ];
    }
}
