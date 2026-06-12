<?php

use App\Models\Chapter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreignIdFor(Chapter::class)->nullable()->after('course_id')->constrained()->nullOnDelete();
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->foreignIdFor(Chapter::class)->nullable()->after('course_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Chapter::class);
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Chapter::class);
        });
    }
};
