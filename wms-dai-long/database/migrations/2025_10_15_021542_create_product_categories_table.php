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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // MAIN, PKG1, PKG2, etc.
            $table->string('name'); // Nguyên liệu chính, Bao bì
            $table->text('description')->nullable();
            $table->string('abc_class')->nullable(); // A, B, C (for inventory management)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
