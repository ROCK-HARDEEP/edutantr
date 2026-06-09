<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalesTeamStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'size:4', Rule::unique('sales_teams', 'code')],
            'daily_target' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'members' => 'nullable|array',
            'members.*.name' => 'required_with:members|string|max:255',
            'members.*.email' => 'required_with:members|email|max:255|distinct|unique:users,email',
            'members.*.password' => 'required_with:members|string|min:6',
            'members.*.is_leader' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.size' => 'Team code must be exactly 4 characters (letters or numbers).',
            'code.unique' => 'This team code is already in use.',
        ];
    }
}
