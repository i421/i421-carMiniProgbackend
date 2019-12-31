<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopSecondHandCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_second_hand_cars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned()->index()->comment("shop ID");
            $table->string('name')->index()->comment("repair店铺名称");
            $table->string('type')->nullable()->comment("车型");
            $table->string('desc')->nullable()->comment("描述");
            $table->string('phone')->nullable()->index()->comment("手机号");
            $table->string('lat')->nullable()->comment("经度");
            $table->string('lng')->nullable()->comment("纬度");
            $table->string('address')->nullable()->comment("address");
            $table->json('img')->nullable()->comment("图片");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('shop_id')
                ->references('id')->on('shops')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_second_hand_cars');
    }
}
