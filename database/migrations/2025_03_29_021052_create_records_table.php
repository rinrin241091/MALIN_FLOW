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
            $table->foreignId('box_id')->constrained()->onDelete('cascade'); // Liên kết với hộp
            $table->string('title'); // Tiêu đề hồ sơ
            $table->string('code')->unique(); // Mã định danh hồ sơ
            $table->text('description')->nullable();
            $table->integer('page_count')->nullable(); // Số trang
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
