<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('doc_code', 25)->comment('Mã định danh văn bản');
            $table->string('file_code', 13)->comment('Mã hồ sơ');
            $table->string('identifier', 13)->comment('Mã cơ quan lưu trữ lịch sử');
            $table->string('organ_id', 13)->comment('Mã phòng/công trình/sưu tập lưu trữ');
            $table->integer('file_catalog')->comment('Mục lục số hồ sơ hình thành hồ sơ');
            $table->string('file_notation', 20)->comment('Số và ký hiệu hồ sơ');
            $table->integer('doc_ordinal')->comment('Số thứ tự văn bản trong hồ sơ');
            $table->string('type_name', 100)->comment('Tên loại văn bản');
            $table->string('code_number', 11)->comment('Số của văn bản');
            $table->string('code_notation', 30)->comment('Ký hiệu của văn bản');
            $table->date('issued_date')->comment('Ngày, tháng, năm văn bản');
            $table->string('organ_name', 200)->comment('Tên cơ quan, tổ chức ban hành văn bản');
            $table->string('subject', 500)->comment('Trích yếu nội dung');
            $table->string('language', 100)->comment('Ngôn ngữ');
            $table->integer('page_amount')->comment('Số lượng trang của văn bản');
            $table->string('description', 500)->nullable()->comment('Ghi chú');
            $table->string('infor_sign', 30)->comment('Ký hiệu thông tin');
            $table->string('keyword', 100)->comment('Từ khóa');
            $table->string('mode', 20)->comment('Chế độ sử dụng');
            $table->string('confidence_level', 30)->comment('Mức độ tin cậy');
            $table->string('autograph', 2000)->comment('Bút tích');
            $table->string('format', 50)->comment('Tình trạng vật lý');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
}; 