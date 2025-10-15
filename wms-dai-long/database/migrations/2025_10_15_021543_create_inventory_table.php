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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->string('lot_number')->nullable(); // LOT-20251015
            $table->date('manufacture_date')->nullable(); // NSX
            $table->date('expiry_date')->nullable(); // HSD
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('available_quantity', 10, 2)->default(0); // Khả dụng
            $table->decimal('reserved_quantity', 10, 2)->default(0); // Đã đặt
            $table->string('status')->default('available'); // available, pending_qc, quarantine, near_expiry, expired
            $table->timestamps();
            
            $table->unique(['product_id', 'warehouse_id', 'location_id', 'lot_number'], 'inventory_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
