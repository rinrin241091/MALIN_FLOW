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
            $table->foreignId('fond_id')->constrained()->onDelete('cascade'); // Liên kết với phông
            $table->string('name'); // Tên kho
            $table->string('code')->unique(); // Mã định danh kho
            $table->string('location')->nullable(); // Vị trí kho
            $table->integer('capacity')->nullable(); // Sức chứa
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
