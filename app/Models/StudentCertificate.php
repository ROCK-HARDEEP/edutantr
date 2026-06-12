<?php

namespace App\Models;

use App\Support\MediaStorage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentCertificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::url($this->media),
        );
    }
}
