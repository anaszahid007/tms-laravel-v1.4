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
        Schema::create('referral_earnings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('referral_partner_id')->constrained('referral_partners')->cascadeOnDelete();
            // Optional: link to conversion if needed, but definitely need to link strictly to partner
            $table->foreignUuid('referral_conversion_id')->nullable()->constrained('referral_conversions')->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->decimal('order_amount', 10, 2)->comment('The amount paid by the shop');
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_earnings');
    }
};
