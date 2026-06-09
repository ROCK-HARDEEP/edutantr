<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomePlacementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_name' => $this->student_name,
            'company_name' => $this->company_name,
            'role' => $this->role,
            'image' => $this->mediaPath,
            'sort_order' => $this->sort_order,
        ];
    }
}
