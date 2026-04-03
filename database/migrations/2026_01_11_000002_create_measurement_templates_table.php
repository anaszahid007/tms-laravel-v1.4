<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurement_templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type'); // e.g. 'shalwar_kameez', 'pant_coat'
            $table->string('name'); // Display name
            $table->string('name_urdu')->nullable(); // Urdu name
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurement_templates');
    }
};
