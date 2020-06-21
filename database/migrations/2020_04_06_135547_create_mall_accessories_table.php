<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMallAccessoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mall_accessories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->comment("名称");
            $table->string('avatar')->nullable()->comment("缩略图");
            $table->integer('mall_accessory_classify_id')->unsigned()->index()->comment("类别");
            $table->integer('price')->index()->comment("原价");
            $table->integer('count')->default(0)->index()->comment("销量");
            $table->string('size')->nullable()->index()->comment("尺寸");
            $table->integer('score_price')->index()->comment("积分价");
            $table->json("detail")->nullable()->comment("规格: 颜色,尺寸...");
            $table->json("carousel")->nullable()->comment("轮播图");
            $table->json("imgs")->nullable()->comment("其他图");
            $table->json("info")->nullable()->comment("其他图");
            $table->integer("status")->default(1)->comment("状态");
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
        Schema::dropIfExists('mall_accessories');
    }
}
