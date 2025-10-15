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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique(); // ZN-WHRM-01-A01-05-02
            $table->string('zone')->nullable(); // Khu vực/Tầng: 01
            $table->string('aisle')->nullable(); // Dãy kệ: A01
            $table->string('rack')->nullable(); // Số kệ: 05
            $table->string('level')->nullable(); // Tầng kệ: 02
            $table->decimal('capacity', 10, 2)->nullable(); // kg or pallets
            $table->string('capacity_unit')->default('kg'); // kg, pallet, m3
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
