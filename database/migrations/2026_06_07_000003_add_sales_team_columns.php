<?php

use App\Models\SalesTeam;
use App\Models\SalesTeamMember;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignIdFor(SalesTeam::class)->nullable()->after('coupon_id')->constrained()->nullOnDelete();
            $table->foreignIdFor(SalesTeamMember::class)->nullable()->after('sales_team_id')->constrained()->nullOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(SalesTeam::class)->nullable()->after('student_organization_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(SalesTeamMember::class);
            $table->dropConstrainedForeignIdFor(SalesTeam::class);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(SalesTeam::class);
        });
    }
};
