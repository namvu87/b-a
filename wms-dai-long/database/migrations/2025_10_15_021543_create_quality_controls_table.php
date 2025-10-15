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
        Schema::create('quality_controls', function (Blueprint $table) {
            $table->id();
            $table->string('qc_number')->unique(); // QC-2025-001
            $table->foreignId('goods_receipt_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('lot_number')->nullable();
            $table->date('inspection_date');
            $table->string('result'); // passed, failed, conditional
            $table->text('appearance')->nullable(); // Ngoại quan
            $table->text('color')->nullable(); // Màu sắc
            $table->text('smell')->nullable(); // Mùi vị
            $table->text('packaging')->nullable(); // Bao bì
            $table->text('expiry_check')->nullable(); // Kiểm tra HSD
            $table->text('other_checks')->nullable(); // Tiêu chí khác
            $table->text('conclusion')->nullable(); // Kết luận
            $table->text('corrective_action')->nullable(); // Hành động khắc phục (nếu không đạt)
            $table->json('images')->nullable(); // Ảnh minh chứng
            $table->foreignId('inspector_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_controls');
    }
};
