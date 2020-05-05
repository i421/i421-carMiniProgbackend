<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMallShoppingCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mall_shopping_carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->comment("客户ID");
            $table->integer('mall_accessory_id')->unsigned()->comment("商城商品ID");
            $table->integer('count')->default(0)->comment("商品数量");
            $table->integer('price')->default(0)->comment("商品单价");
            $table->integer('status')->default(1)->comment("商品状态");
            $table->json('detail')->nullable()->comment("商品明细");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onUpdate('cascade');

            $table->foreign('mall_accessory_id')
                ->references('id')->on('mall_accessories')
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
        Schema::dropIfExists('mall_shopping_carts');
    }
}
