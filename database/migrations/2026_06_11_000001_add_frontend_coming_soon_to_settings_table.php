<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('frontend_coming_soon')->default(false)->after('hero_description');
            $table->string('coming_soon_title')->nullable()->after('frontend_coming_soon');
            $table->text('coming_soon_message')->nullable()->after('coming_soon_title');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['frontend_coming_soon', 'coming_soon_title', 'coming_soon_message']);
        });
    }
};
