<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_events', function (Blueprint $table) {
            $table->string('certificate_signer_name')->nullable()->after('event_url');
            $table->string('certificate_signer_title')->nullable()->after('certificate_signer_name');
        });

        Schema::table('event_registrations', function (Blueprint $table) {
            $table->string('certificate_code', 32)->nullable()->unique()->after('read_at');
            $table->timestamp('certificate_issued_at')->nullable()->after('certificate_code');
            $table->timestamp('certificate_emailed_at')->nullable()->after('certificate_issued_at');
            $table->timestamp('certificate_revoked_at')->nullable()->after('certificate_emailed_at');
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropUnique(['certificate_code']);
            $table->dropColumn(['certificate_code', 'certificate_issued_at', 'certificate_emailed_at', 'certificate_revoked_at']);
        });
        Schema::table('site_events', fn (Blueprint $table) => $table->dropColumn(['certificate_signer_name', 'certificate_signer_title']));
    }
};
