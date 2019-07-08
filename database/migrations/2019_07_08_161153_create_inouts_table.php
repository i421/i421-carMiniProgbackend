<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //进出货表
        Schema::create('inouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned()->index()->comment("店铺ID");
            $table->integer('car_id')->unsigned()->index()->comment("汽车ID");
            $table->integer('type')->index()->comment("进货1/出货0");
            $table->integer('count')->default(0)->index()->comment("数量");
            $table->json('info')->nullable()->comment("其他信息");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('shop_id')
                ->references('id')->on('shops')
                ->onUpdate('cascade');

            $table->foreign('car_id')
                ->references('id')->on('cars')
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
        Schema::dropIfExists('inouts');
    }
}
