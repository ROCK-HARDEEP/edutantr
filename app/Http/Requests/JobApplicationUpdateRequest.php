<?php

namespace App\Http\Requests;

use App\Enum\JobApplicationStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobApplicationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(JobApplicationStatusEnum::class)],
            'admin_notes' => 'nullable|string|max:2000',
        ];
    }
}
