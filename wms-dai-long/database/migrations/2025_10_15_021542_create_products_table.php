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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('product_categories')->onDelete('cascade');
            $table->string('code')->unique(); // MAIN_gao01, PKG1_thung01
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('unit'); // kg, thùng, cái, lít
            $table->string('barcode')->nullable();
            $table->boolean('has_expiry')->default(false); // Có hạn sử dụng không
            $table->integer('shelf_life_days')->nullable(); // Hạn sử dụng (số ngày)
            $table->decimal('min_stock', 10, 2)->default(0); // Tồn kho tối thiểu
            $table->decimal('max_stock', 10, 2)->default(0); // Tồn kho tối đa
            $table->string('abc_class')->nullable(); // A, B, C
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
