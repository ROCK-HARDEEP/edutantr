<?php

namespace App\Http\Resources;

use App\Enum\MediaTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollegeGalleryItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $mediaType = $this->media?->type?->value ?? 'image';

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'section_type' => $this->section_type?->value,
            'section_label' => $this->section_type?->label(),
            'media_type' => $mediaType,
            'media_url' => $this->mediaPath,
            'event_date' => $this->event_date?->format('M d, Y'),
            'sort_order' => $this->sort_order,
            'college' => $this->when($this->college, [
                'id' => $this->college?->id,
                'name' => $this->college?->name,
                'location' => $this->college?->location,
                'logo' => $this->college?->mediaPath,
            ]),
            'is_video' => $mediaType === MediaTypeEnum::VIDEO->value,
        ];
    }
}
