<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['listing_id']);
        });

        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('listing_id')->nullable()->change();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('listing_id')->references('id')->on('listings')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['listing_id']);
        });

        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('listing_id')->nullable(false)->change();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('listing_id')->references('id')->on('listings')->cascadeOnDelete();
        });
    }
};
