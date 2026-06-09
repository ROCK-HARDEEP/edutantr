<?php

namespace App\Http\Requests;

use App\Enum\CollegeGallerySectionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollegeGalleryItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $item = $this->route('college_gallery');

        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'partner_college_id' => 'nullable|exists:partner_colleges,id',
            'section_type' => ['required', Rule::enum(CollegeGallerySectionEnum::class)],
            'event_date' => 'nullable|date',
            'sort_order' => 'nullable|integer|min:0',
            'media' => ($item ? 'nullable' : 'required') . '|file|mimes:jpeg,png,jpg,gif,webp,mp4,mpeg,webm,mov|max:51200',
        ];
    }
}
