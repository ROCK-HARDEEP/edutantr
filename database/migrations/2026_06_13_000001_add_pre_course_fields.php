<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->boolean('pre_course_enabled')->default(false)->after('price');
            $table->decimal('pre_course_price', 10, 2)->nullable()->after('pre_course_enabled');
            $table->text('pre_course_description')->nullable()->after('pre_course_price');
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('enrollment_type')->default('full')->after('course_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->string('enrollment_type')->default('full')->after('course_id');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['pre_course_enabled', 'pre_course_price', 'pre_course_description']);
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn('enrollment_type');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('enrollment_type');
        });
    }
};
