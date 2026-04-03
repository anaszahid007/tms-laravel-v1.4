<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('shop_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('customer_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('template_id')->nullable()->constrained('measurement_templates')->onDelete('set null');
            
            $table->string('measurement_key'); 

            $table->jsonb('data'); // Stores chest, waist, length, etc.
            $table->string('type'); // e.g. 'shalwar_kameez', 'pant_coat'
            $table->string('language')->default('en'); // 'en' or 'ur'
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('template_id');
            $table->index('customer_id');
            $table->index('measurement_key');

            $table->unique(['shop_id', 'measurement_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
