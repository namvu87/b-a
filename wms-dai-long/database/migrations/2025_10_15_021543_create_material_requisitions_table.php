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
        Schema::create('material_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('requisition_number')->unique(); // YCVT-2025-001
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->string('department'); // Phòng/Bộ phận yêu cầu (Sản xuất, Kinh doanh)
            $table->date('request_date');
            $table->date('needed_date')->nullable(); // Ngày cần hàng
            $table->string('status')->default('pending'); // pending, approved, preparing, completed, rejected
            $table->text('purpose')->nullable(); // Mục đích sử dụng
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requisitions');
    }
};
