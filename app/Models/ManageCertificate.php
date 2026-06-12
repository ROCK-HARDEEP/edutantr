<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\MediaStorage;
use Illuminate\Support\Facades\Storage;

class ManageCertificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    public function siteLogo(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'site_logo_id');
    }

    public function siteLogoPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->siteLogo, asset('enrollment/logo.png')),
        );
    }
    public function subSiteLogo(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'subsite_logo_id');
    }

    public function subSiteLogoPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->subSiteLogo, asset('enrollment/logo.png')),
        );
    }

    public function authSignature(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'author_signature_id');
    }

    public function authSignaturePath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->authSignature, asset('enrollment/signature.jpg')),
        );
    }

    public function frame(): BelongsTo
    {
        return $this->belongsTo(Frame::class, 'frame_id');
    }

    public function framePath(): Attribute
    {
        $frame = asset('assets/certificate/themeone.png');

        if ($this->frame && Storage::exists($this->frame->src)) {
            $frame = Storage::url($this->frame->src);
        }

        return Attribute::make(
            get: fn() => $frame,
        );
    }
}
