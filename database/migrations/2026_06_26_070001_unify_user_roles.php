<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing tenant and buyer accounts to unified 'user' role
        DB::table('users')
            ->whereIn('role', ['tenant', 'buyer'])
            ->update(['role' => 'user']);

        // Also update the default value on the column
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('tenant')->change();
        });
    }
};
