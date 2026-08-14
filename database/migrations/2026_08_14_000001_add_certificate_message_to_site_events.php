<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_events', function (Blueprint $table) {
            $table->text('certificate_message')->nullable()->after('certificate_signer_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_events', fn (Blueprint $table) => $table->dropColumn('certificate_message'));
    }
};
