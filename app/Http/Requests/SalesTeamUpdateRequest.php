<?php

namespace App\Http\Requests;

use App\Models\SalesTeamMember;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SalesTeamUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teamId = $this->route('sales_team')?->id ?? $this->route('sales_team');

        return [
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'size:4', Rule::unique('sales_teams', 'code')->ignore($teamId)],
            'daily_target' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'members' => 'nullable|array',
            'members.*.id' => 'nullable|integer|exists:sales_team_members,id',
            'members.*.name' => 'required_with:members|string|max:255',
            'members.*.email' => 'required_with:members|email|max:255',
            'members.*.password' => 'nullable|string|min:6',
            'members.*.is_leader' => 'nullable|boolean',
            'members.*.is_active' => 'nullable|boolean',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $members = $this->input('members', []);

            foreach ($members as $index => $member) {
                if (empty($member['email'])) {
                    continue;
                }

                $userId = null;
                if (!empty($member['id'])) {
                    $userId = SalesTeamMember::find($member['id'])?->user_id;
                }

                $emailTaken = User::where('email', $member['email'])
                    ->when($userId, fn ($query) => $query->where('id', '!=', $userId))
                    ->exists();

                if ($emailTaken) {
                    $validator->errors()->add("members.{$index}.email", 'This email is already taken.');
                }

                $needsPassword = empty($member['id']) || !$userId;
                if ($needsPassword && empty($member['password'])) {
                    $validator->errors()->add("members.{$index}.password", 'Password is required to create counselor login.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'code.size' => 'Team code must be exactly 4 characters (letters or numbers).',
            'code.unique' => 'This team code is already in use.',
        ];
    }
}
