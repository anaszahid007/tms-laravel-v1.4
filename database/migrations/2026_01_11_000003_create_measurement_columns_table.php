<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurement_columns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('template_id')->constrained('measurement_templates')->onDelete('cascade');
            $table->string('field_name'); // e.g. 'length', 'chest'
            $table->string('label'); // Display label
            $table->string('label_urdu')->nullable(); // Urdu label
            $table->string('unit')->default('inch'); // cm, inch, etc.
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('template_id');
            $table->index('sort_order');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurement_columns');
    }
};
