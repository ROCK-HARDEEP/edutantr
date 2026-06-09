<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status?->value,
            'status_label' => $this->status?->label(),
            'cover_letter' => $this->cover_letter,
            'resume_url' => $this->resumeUrl,
            'admin_notes' => $this->when($request->user()?->is_admin, $this->admin_notes),
            'applied_at' => $this->created_at?->format('M d, Y'),
            'job_post' => new JobPostResource($this->whenLoaded('jobPost')),
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'profile_picture' => $this->user->profilePicturePath,
            ]),
        ];
    }
}
