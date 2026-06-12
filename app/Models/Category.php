<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\MediaStorage;

class Category extends Model
{
    protected $guarded = ['id'];

    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->image, 'https://placehold.co/512x512'),
        );
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
