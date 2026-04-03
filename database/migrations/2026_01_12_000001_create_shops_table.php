<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->string('shop_key')->unique();
            $table->timestamp('subscription_ends_at')->nullable()->index();
            $table->enum('status', ['active', 'expired', 'trial'])->default('trial');
            $table->boolean('is_suspended')->default(false);
            $table->boolean('customers_public')->default(false);
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // Referral system linkage
            $table->foreignUuid('referral_partner_id')->nullable()->constrained('referral_partners')->nullOnDelete();
            $table->integer('referral_commission_count')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
