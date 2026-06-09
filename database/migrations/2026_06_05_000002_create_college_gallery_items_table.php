<?php

use App\Models\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('college_gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('partner_college_id')->nullable()->constrained('partner_colleges')->nullOnDelete();
            $table->foreignId('media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('section_type', [
                'mou',
                'academic_partnership',
                'workshop',
                'seminar',
                'internship_drive',
                'event_highlight',
            ])->default('workshop');
            $table->date('event_date')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('college_gallery_items');
    }
};
