<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('contact_offers_title')->nullable()->after('hero_description');
            $table->text('contact_offers_description')->nullable()->after('contact_offers_title');
            $table->string('contact_offers_icon')->nullable()->after('contact_offers_description');
            $table->foreignId('contact_offers_image_id')->nullable()->after('contact_offers_icon')->constrained('media')->nullOnDelete();
            $table->text('head_office_address')->nullable()->after('contact_offers_image_id');
        });

        Schema::table('organization_site_settings', function (Blueprint $table) {
            $table->string('contact_offers_title')->nullable()->after('whatsapp_support_number');
            $table->text('contact_offers_description')->nullable()->after('contact_offers_title');
            $table->string('contact_offers_icon')->nullable()->after('contact_offers_description');
            $table->foreignId('contact_offers_image_id')->nullable()->after('contact_offers_icon')->constrained('media')->nullOnDelete();
            $table->text('head_office_address')->nullable()->after('contact_offers_image_id');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('contact_offers_image_id');
            $table->dropColumn([
                'contact_offers_title',
                'contact_offers_description',
                'contact_offers_icon',
                'head_office_address',
            ]);
        });

        Schema::table('organization_site_settings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('contact_offers_image_id');
            $table->dropColumn([
                'contact_offers_title',
                'contact_offers_description',
                'contact_offers_icon',
                'head_office_address',
            ]);
        });
    }
};
