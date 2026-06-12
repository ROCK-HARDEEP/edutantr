<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\MediaStorage;

class OfferBanner extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->media, asset('media/demoimage.png')),
        );
    }
}
