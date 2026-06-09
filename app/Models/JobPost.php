<?php

namespace App\Models;

use App\Enum\JobPostStatusEnum;
use App\Enum\JobTypeEnum;
use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'application_deadline' => 'date',
        'is_active' => 'boolean',
        'status' => JobPostStatusEnum::class,
        'job_type' => JobTypeEnum::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function isOpen(): bool
    {
        if ($this->status !== JobPostStatusEnum::OPEN || !$this->is_active) {
            return false;
        }

        if ($this->application_deadline && $this->application_deadline->isPast()) {
            return false;
        }

        return true;
    }
}
