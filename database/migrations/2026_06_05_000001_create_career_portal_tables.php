<?php

use App\Models\JobCategory;
use App\Models\JobPost;
use App\Models\Media;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class)->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(JobCategory::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('company_name')->nullable();
            $table->string('location')->nullable();
            $table->string('job_type')->default('full_time');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('salary_range')->nullable();
            $table->date('application_deadline')->nullable();
            $table->string('status')->default('open');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JobPost::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Media::class, 'resume_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->text('cover_letter')->nullable();
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['job_post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('job_posts');
        Schema::dropIfExists('job_categories');
    }
};
