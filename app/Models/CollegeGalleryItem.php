<?php

namespace App\Models;

use App\Enum\CollegeGallerySectionEnum;
use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\MediaStorage;

class CollegeGalleryItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'section_type' => CollegeGallerySectionEnum::class,
        'event_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(PartnerCollege::class, 'partner_college_id');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function mediaPath(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->media && MediaStorage::exists($this->media)) {
                    return MediaStorage::url($this->media);
                }

                return asset('assets/images/profile/demo-profile.png');
            },
        );
    }
}
