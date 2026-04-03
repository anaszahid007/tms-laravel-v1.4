<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('customer_key')->unique();
            $table->foreignUuid('shop_id')->constrained()->onDelete('cascade');
            $table->string('name')->index();
            $table->string('father_name')->nullable()->index();
            $table->string('phone')->index();
            $table->text('address')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('male');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
