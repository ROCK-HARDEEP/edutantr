<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'program_type' => $this->program_type,
            'cta_label' => $this->cta_label,
            'cta_url' => $this->cta_url,
            'image' => $this->mediaPath,
            'sort_order' => $this->sort_order,
        ];
    }
}
