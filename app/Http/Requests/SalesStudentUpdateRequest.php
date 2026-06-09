<?php

namespace App\Http\Requests;

use App\Rules\MailRules;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class SalesStudentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'phone' => ['required', 'unique:users,phone,' . $userId, new PhoneNumber()],
            'email' => ['required', 'email', new MailRules(), 'unique:users,email,' . $userId],
            'password' => 'nullable|min:8|confirmed',
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
