<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payment_transactions')) {
            Schema::create('payment_transactions', function (Blueprint $table) {
                $table->id();
                $table->string('transaction_id')->unique(); // Our internal ref (e.g. STK push checkout request id or custom)
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
                $table->string('type'); // 'booking', 'reservation'
                $table->decimal('amount', 10, 2);
                $table->string('currency', 3)->default('KES'); // TZ uses TZS usually, but will be configurable
                $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
                $table->string('payment_method')->default('M-Pesa');
                $table->string('mpesa_receipt')->nullable()->unique();
                $table->string('phone_number')->nullable();
                $table->text('result_desc')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
