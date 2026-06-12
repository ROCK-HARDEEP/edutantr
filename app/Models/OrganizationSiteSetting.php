<?php

namespace App\Models;

use App\Support\MediaStorage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationSiteSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function logo(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function logoPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->logo, asset('assets/images/logo-new.png')),
        );
    }

    public function footer(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'footerlogo_id');
    }

    public function footerPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->footer, asset('assets/images/logo-new.png')),
        );
    }

    public function favicon(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function faviconPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->favicon, asset('assets/images/favicon.ico')),
        );
    }

    public function scaner(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function scanerPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->scaner, asset('assets/website/scaner/scan.png')),
        );
    }

    public function contactOffersImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'contact_offers_image_id');
    }

    public function contactOffersImagePath(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->contactOffersImage
                ? MediaStorage::urlOrDefault($this->contactOffersImage, '')
                : '',
        );
    }
}
