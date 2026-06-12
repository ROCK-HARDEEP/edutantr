<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentCertificateStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ];
    }
}
