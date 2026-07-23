<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('site_event_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone', 40)->nullable();
            $table->string('company')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();

            $table->foreign('site_event_id')->references('id')->on('site_events')->cascadeOnDelete();
            $table->index(['site_event_id', 'created_at']);
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
