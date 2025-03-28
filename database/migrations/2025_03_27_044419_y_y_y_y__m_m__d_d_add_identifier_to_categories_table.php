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
        // Sửa bảng categories để thêm cột identifier
        Schema::table('categories', function (Blueprint $table) 
        {
            // Thêm cột identifier để lưu mã định danh, có thể null, phải duy nhất
            $table->string('identifier')->nullable()->unique()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa cột identifier khi rollback migration
        Schema::table('categories', function (Blueprint $table) 
        {
            $table->dropColumn('identifier');
        });
    }
};
