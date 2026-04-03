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
        Schema::create('shop_subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->foreignUuid('shop_id')->constrained('shops')->cascadeOnDelete();
            $table->foreignUuid('subscription_plan_id')->constrained('subscription_plans')->cascadeOnDelete();
            
            // Subscription timing
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->dateTime('grace_period_ends_at')->nullable();
            
            // Status tracking
            $table->enum('status', ['active', 'grace', 'expired', 'pending_payment'])->default('pending_payment');
            $table->boolean('is_active')->default(false);
            
            // Payment information
            $table->string('payment_status')->default('pending'); // pending, approved, rejected
            $table->string('payment_proof_path')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('expiry_notified_at')->nullable();
            
            // Plan snapshot (copied at subscription time)
            $table->string('plan_name');
            $table->decimal('plan_price', 10, 2);
            $table->integer('plan_duration_days');
            $table->jsonb('plan_features')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['shop_id', 'is_active']);
            $table->index('ends_at');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_subscriptions');
    }
};