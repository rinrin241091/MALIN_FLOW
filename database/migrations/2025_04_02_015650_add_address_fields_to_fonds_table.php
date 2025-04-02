<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tạo bảng province
        Schema::create('province', function (Blueprint $table) {
            $table->integer('province_id');
            $table->string('name', 64);
            $table->engine = 'MyISAM';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->comment('Tỉnh thành');
        });

        // 2. Tạo bảng district
        Schema::create('district', function (Blueprint $table) {
            $table->integer('district_id');
            $table->integer('province_id');
            $table->string('name', 64);
            $table->engine = 'MyISAM';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->comment('Quận huyện');
        });

        // 3. Tạo bảng wards
        Schema::create('wards', function (Blueprint $table) {
            $table->integer('wards_id');
            $table->integer('district_id');
            $table->string('name', 64);
            $table->engine = 'MyISAM';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->comment('Xã Phường');
        });

        // 4. Thêm các trường vào bảng fonds
        Schema::table('fonds', function (Blueprint $table) {
            if (!Schema::hasColumn('fonds', 'address')) {
                $table->string('address')->nullable()->after('description');
            }
            if (!Schema::hasColumn('fonds', 'province_id')) {
                $table->integer('province_id')->nullable()->after('address');
            }
            if (!Schema::hasColumn('fonds', 'district_id')) {
                $table->integer('district_id')->nullable()->after('province_id');
            }
            if (!Schema::hasColumn('fonds', 'wards_id')) {
                $table->integer('wards_id')->nullable()->after('district_id');
            }
        });
    }

    public function down()
    {
        Schema::table('fonds', function (Blueprint $table) {
            $table->dropColumn(['address', 'province_id', 'district_id', 'wards_id']);
        });

        Schema::dropIfExists('wards');
        Schema::dropIfExists('district');
        Schema::dropIfExists('province');
    }
};