<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_events', function (Blueprint $table) {
            $table->text('excerpt')->change();
            $table->text('cta_url')->default('/contact')->change();
            $table->text('event_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('site_events', function (Blueprint $table) {
            $table->string('excerpt')->change();
            $table->string('cta_url')->default('/contact')->change();
            $table->string('event_url')->nullable()->change();
        });
    }
};
