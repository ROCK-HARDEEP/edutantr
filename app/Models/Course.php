<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\MediaStorage;

class Course extends Model
{
    protected $guarded = ['id'];

    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class)->withTrashed();
    }
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class)->withTrashed();
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->withTrashed();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function mediaPath(): Attribute
    {
        return Attribute::make(
            get: fn () => MediaStorage::urlOrDefault($this->media, 'https://placehold.co/350x200'),
        );
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'video_id');
    }

    public function videoPath(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->video && MediaStorage::exists($this->video)) {
                    return MediaStorage::url($this->video);
                }

                return null;
            },
        );
    }

    public function favouriteUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_courses');
    }

    public function favouriteGuests(): BelongsToMany
    {
        return $this->belongsToMany(Guest::class, 'guest_courses');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function userProgress()
    {
        return $this->belongsToMany(User::class, 'user_course_progresses')->withPivot('progress', 'course_id');
    }

    public function invoices(): belongsToMany
    {
        return $this->belongsToMany(Invoice::class);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_course');
    }

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscriber_courses');
    }

    public function project()
    {
        return $this->hasOne(CourseProject::class);
    }
}
