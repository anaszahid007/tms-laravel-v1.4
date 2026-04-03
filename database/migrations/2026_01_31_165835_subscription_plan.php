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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique(); // e.g., "Monthly Basic", "Yearly Premium"
            $table->string('slug')->unique(); // For URL usage
            $table->integer('discount_percentage')->default(0);
            $table->decimal('price', 10, 2);
            $table->integer('duration_days'); // 30 for monthly, 365 for yearly
            $table->text('description')->nullable();
            $table->jsonb('features')->nullable(); // Store list of features as JSON
            $table->boolean('is_active')->default(true);
            $table->boolean('is_free')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
