<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMallAccessoryClassifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mall_accessory_classifies', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->index()->comment("分类名称");
            $table->integer("type")->index()->default(1)->comment("一级分类1/二级分类2");
            $table->string("p_name")->index()->comment("一级分类名称");
            $table->string("p_id")->index()->comment("一级分类名称");
            $table->integer("height")->index()->default(1)->comment("权重");
            $table->string("img")->index()->nullable()->comment("图标");
            $table->json("info")->nullable()->comment("其他信息");
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
        Schema::dropIfExists('mall_accessory_classifies');
    }
}
