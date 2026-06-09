<?php

namespace App\Http\Requests;

use App\Rules\MailRules;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class SalesStudentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'unique:users,phone', new PhoneNumber()],
            'email' => ['required', 'email', new MailRules(), 'unique:users,email'],
            'password' => 'required|confirmed|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
        ];
    }
}
