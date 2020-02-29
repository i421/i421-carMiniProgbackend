<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment("套餐名称");
            $table->integer('maintenance_count')->comment("保养次数");
            $table->integer('price')->comment("价格");
            $table->string('min_price')->comment("最低价格");
            $table->string('max_price')->comment("最高价格");
            $table->string('desc')->nullable()->comment("描述");
            $table->string('img')->nullable()->comment("图片");
            $table->json('info')->nullable()->comment("其他信息");
            $table->softDeletes()->comment('软删除');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
