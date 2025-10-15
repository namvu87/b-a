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
        Schema::create('goods_issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_number')->unique(); // PX-2025-001
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->string('type'); // to_production, to_customer, transfer, return_supplier
            $table->date('issue_date');
            $table->string('reference_number')->nullable(); // Số đơn hàng/YCVT
            $table->string('recipient_name')->nullable(); // Người nhận
            $table->string('recipient_department')->nullable(); // Phòng ban nhận
            $table->string('status')->default('pending'); // pending, approved, completed, cancelled
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_issues');
    }
};
