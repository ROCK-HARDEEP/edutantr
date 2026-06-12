<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\MediaStorage;

class Article extends Model
{
    use HasFactory;

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function mediaPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->media, asset('media/dummy-image.jpg')),
        );
    }
}
