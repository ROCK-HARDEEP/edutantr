<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'company_name' => $this->company_name,
            'location' => $this->location,
            'job_type' => $this->job_type?->value,
            'job_type_label' => $this->job_type?->label(),
            'description' => $this->description,
            'requirements' => $this->requirements,
            'salary_range' => $this->salary_range,
            'application_deadline' => $this->application_deadline?->format('Y-m-d'),
            'status' => $this->status?->value,
            'status_label' => $this->status?->label(),
            'is_open' => $this->isOpen(),
            'category' => new JobCategoryResource($this->whenLoaded('category')),
            'applications_count' => $this->whenCounted('applications'),
            'created_at' => $this->created_at?->format('M d, Y'),
        ];
    }
}
