<?php

namespace App\Http\Requests;

use App\Enum\JobPostStatusEnum;
use App\Enum\JobTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobPostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_category_id' => 'required|exists:job_categories,id',
            'title' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => ['required', Rule::enum(JobTypeEnum::class)],
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salary_range' => 'nullable|string|max:255',
            'application_deadline' => 'nullable|date',
            'status' => ['nullable', Rule::enum(JobPostStatusEnum::class)],
        ];
    }
}
