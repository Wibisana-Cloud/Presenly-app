<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->unique(['user_id', 'tanggal']);
            $table->index('status');
            $table->index('tanggal');
        });

        Schema::table('izins', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('lemburans', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'tanggal']);
            $table->dropIndex(['status']);
            $table->dropIndex(['tanggal']);
        });

        Schema::table('izins', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('lemburans', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
