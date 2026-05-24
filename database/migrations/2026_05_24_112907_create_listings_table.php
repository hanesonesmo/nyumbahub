<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // agent
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['rent', 'sale']);
            $table->enum('category', ['apartment', 'house', 'villa', 'land', 'commercial']);
            $table->decimal('price', 12, 2);
            $table->string('location');
            $table->string('address')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('area', 8, 2)->nullable(); // in m²
            $table->string('image')->nullable();
            $table->enum('status', ['pending', 'active', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
