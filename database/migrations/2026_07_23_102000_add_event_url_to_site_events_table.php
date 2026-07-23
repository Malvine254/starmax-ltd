<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_events', function (Blueprint $table) {
            $table->string('event_url', 1000)->nullable()->after('cta_url');
        });
    }

    public function down(): void
    {
        Schema::table('site_events', function (Blueprint $table) {
            $table->dropColumn('event_url');
        });
    }
};
