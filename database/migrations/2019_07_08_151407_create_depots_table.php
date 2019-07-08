<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //库存表
        Schema::create('depots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned()->index()->comment("店铺ID");
            $table->integer('car_id')->unsigned()->index()->comment("汽车ID");
            $table->integer('total')->default(0)->index()->comment("仓库余量");
            $table->json('info')->nullable()->comment("其余信息");
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
        Schema::dropIfExists('depots');
    }
}
