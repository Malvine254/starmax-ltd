<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('format')->nullable();
            $table->string('location');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->string('excerpt');
            $table->text('description');
            $table->string('cta_label')->default('Request Invite');
            $table->string('cta_url')->default('/contact');
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('upcoming');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['status', 'starts_at']);
            $table->index(['is_featured', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_events');
    }
};
