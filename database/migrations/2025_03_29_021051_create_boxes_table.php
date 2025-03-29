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
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shelf_id')->constrained()->onDelete('cascade'); // Liên kết với kệ
            $table->string('name'); // Tên hộp
            $table->string('code')->unique(); // Mã định danh hộp
            $table->integer('capacity')->nullable(); // Sức chứa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boxes');
    }
};
