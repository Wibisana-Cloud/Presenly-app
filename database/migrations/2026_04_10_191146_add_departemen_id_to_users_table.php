<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! \Illuminate\Support\Facades\Schema::hasColumn('users', 'departemen_id')) {
                $table->foreignId('departemen_id')->nullable()->after('role_id')->constrained('departemens')->nullOnDelete();
            } else {
                $table->foreign('departemen_id')->references('id')->on('departemens')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['departemen_id']);
            $table->dropColumn('departemen_id');
        });
    }
};
