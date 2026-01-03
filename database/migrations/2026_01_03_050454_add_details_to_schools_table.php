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
        Schema::table('schools', function (Blueprint $table) {
            if (!Schema::hasColumn('schools', 'phone')) {
                $table->string('phone')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('schools', 'email')) {
                $table->string('email')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('schools', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
            if (!Schema::hasColumn('schools', 'logo')) {
                $table->string('logo')->nullable()->after('website');
            }
            if (!Schema::hasColumn('schools', 'headmaster_name')) {
                $table->string('headmaster_name')->nullable()->after('logo');
            }
            if (!Schema::hasColumn('schools', 'headmaster_nip')) {
                $table->string('headmaster_nip')->nullable()->after('headmaster_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['phone', 'email', 'website', 'logo', 'headmaster_name', 'headmaster_nip']);
        });
    }
};
