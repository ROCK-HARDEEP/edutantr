<?php

namespace App\Models;

use App\Enum\MediaTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Support\MediaStorage;

class Content extends Model
{
    protected $guarded = ['id'];

    use HasFactory;

    protected $casts = [
        'type' => MediaTypeEnum::class
    ];

    protected static function boot()
    {
        parent::boot();

        // Order contents with serial number by default
        static::addGlobalScope('serial_number', function ($builder) {
            $builder->orderBy('serial_number');
        });
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function mediaPath(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->media && MediaStorage::exists($this->media)) {
                    return MediaStorage::url($this->media);
                }

                return asset($this->media->src ?? 'media/dummy-image.jpg');
            },
        );
    }

    public function contentViews(): HasMany
    {
        return $this->hasMany(UserContentView::class, 'content_id');
    }


    public static function filterType($type)
    {
        switch ($type->value) {
            case 'video':
                return 'bi-camera-reels';
            case 'audio':
                return 'bi-mic';
            case 'document':
                return 'bi-archive';
            case 'image':
                return 'bi-file-earmark-image';
            case 'text':
                return 'bi-blockquote-left';
            default:
                return 'bi-file-earmark-fill';
        }
    }
}
