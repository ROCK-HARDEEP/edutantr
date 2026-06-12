<?php

namespace App\Http\Requests;

use App\Rules\MailRules;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'phone' => ['required', 'unique:users,phone,',  new PhoneNumber()],
            'email' => ['required', 'email', new MailRules(), 'unique:users,email'],
            'password' => 'required|confirmed|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'course_id' => 'nullable|exists:courses,id',
            'sales_team_id' => 'nullable|exists:sales_teams,id',
            'payment_status' => 'nullable|in:paid,unpaid',
            'fcm_token' => 'string',
        ];
    }
}
