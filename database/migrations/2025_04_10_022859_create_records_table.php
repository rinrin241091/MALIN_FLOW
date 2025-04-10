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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fond_id')->constrained('fonds')->onDelete('cascade'); // Liên kết với phông chỉnh lý
            $table->string('title'); // Tiêu đề tài liệu
            $table->string('author')->nullable(); // Tác giả
            $table->date('created_date')->nullable(); // Ngày tạo
            $table->text('description')->nullable(); // Mô tả
            $table->string('code')->unique(); // Mã định danh tài liệu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
