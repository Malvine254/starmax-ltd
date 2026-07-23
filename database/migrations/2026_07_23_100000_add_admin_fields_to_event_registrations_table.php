<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->string('status', 30)->default('new')->after('message');
            $table->text('admin_notes')->nullable()->after('status');
            $table->timestamp('read_at')->nullable()->after('admin_notes');
            $table->index(['status', 'created_at']);
            $table->index(['read_at', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['read_at', 'created_at']);
            $table->dropColumn(['status', 'admin_notes', 'read_at']);
        });
    }
};
