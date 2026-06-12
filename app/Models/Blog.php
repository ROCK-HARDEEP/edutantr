<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\MediaStorage;

class Blog extends Model
{
    protected $guarded = ['id'];

    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function mediaPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->media, 'https://placehold.co/600x400'),
        );
    }
}
