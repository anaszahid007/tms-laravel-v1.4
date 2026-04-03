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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->foreignUuid('shop_id')->constrained('shops')->cascadeOnDelete();
            $table->foreignUuid('subscription_plan_id')->constrained('subscription_plans')->cascadeOnDelete();
            
            // Payment details
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('PKR');
            $table->string('status')->default('pending'); // pending, approved, rejected
            
            // Manual payment proof
            $table->string('payment_proof_path')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('shop_notes')->nullable(); // Notes from shop owner
            $table->text('admin_notes')->nullable(); // Notes from admin
            
            // Admin who approved/rejected
            $table->foreignUuid('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('processed_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['shop_id', 'status']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};