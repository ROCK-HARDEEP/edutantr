<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentCertificateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'file_url' => $this->file_url,
            'extension' => $this->media?->extension,
            'uploaded_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
