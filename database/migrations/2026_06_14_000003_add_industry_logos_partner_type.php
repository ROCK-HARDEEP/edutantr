<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE partner_logos MODIFY COLUMN partner_type ENUM('college', 'company', 'industry_logos') NOT NULL DEFAULT 'company'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE partner_logos MODIFY COLUMN partner_type ENUM('college', 'company') NOT NULL DEFAULT 'company'");
    }
};
