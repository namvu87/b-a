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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // ZN-WHRM-01
            $table->string('name'); // Kho Nguyên vật liệu
            $table->string('type'); // WHRM, WHSP, WHSF, WHFG, WHDC, WHSR
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->decimal('area', 10, 2)->nullable(); // m2
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
