<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('app_name')->nullable()->after('admin_footer_text');
            $table->string('app_currency', 3)->nullable()->after('app_name');
            $table->string('app_currency_symbol', 5)->nullable()->after('app_currency');
        });

        $setting = Setting::query()->first();

        if ($setting) {
            $setting->update([
                'app_name' => $setting->app_name ?: config('app.name'),
                'app_currency' => $setting->app_currency ?: config('app.currency'),
                'app_currency_symbol' => $setting->app_currency_symbol ?: config('app.currency_symbol'),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['app_name', 'app_currency', 'app_currency_symbol']);
        });
    }
};
