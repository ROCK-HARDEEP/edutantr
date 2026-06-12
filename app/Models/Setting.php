<?php

namespace App\Models;

use App\Support\MediaStorage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'frontend_coming_soon' => 'boolean',
        'show_banner' => 'boolean',
        'publish_plan' => 'boolean',
    ];

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
        return $this->belongsTo(Media::class, 'favicon_id');
    }

    public function faviconPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->favicon, asset('assets/images/favicon.ico')),
        );
    }

    public function hero(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'hero_thumbnail_id');
    }

    public function heroPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->hero, asset('assets/website/banner-hero.png')),
        );
    }

    public function about(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'about_thumbnail_id');
    }

    public function aboutPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->about, asset('assets/images/website/about-us.png')),
        );
    }

    public function footerBG(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'footer_bg_thumbnail_id');
    }

    public function footerBGPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->footerBG, asset('assets/website/footer-bg-2.png')),
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
}
