<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Add status column to listings table
        // Run this only if listings table exists
        if (Schema::hasTable('listings')) {
            Schema::table('listings', function (Blueprint $table) {
                $table->enum('status', ['pending', 'active', 'rejected'])->default('pending');
                $table->text('rejection_reason')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
