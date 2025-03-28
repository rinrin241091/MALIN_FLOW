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
        //Tạo bảng documents để lưu trữ tài liệu
        Schema::create('document', function (Blueprint $table)
        {
            $table->id();
            $table->string('title');
            $table->string('identifier');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa bảng documents khi rollback migration
        Schema::dropIfExists('document');
    }
};
