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
        Schema::create('fonds', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Tên phông (cơ quan, đơn vị)
            $table->string('code')->unique(); // Mã định danh phông
            $table->text('description')->nullable(); // Mô tả
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fonds');
    }
};
