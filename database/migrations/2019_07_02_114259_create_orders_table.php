<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_num')->unique()->index()->comment("订单编号");
            $table->integer('customer_id')->unsigned()->comment("客户ID");
            $table->integer('shop_id')->unsigned()->comment("店铺ID");
            $table->integer('car_id')->unsigned()->comment("汽车");
            $table->integer('type')->index()->nullable()->comment("类型:现车，拼团");
            $table->integer('fighting_group_id')->unsigned()->nullable()->comment("拼团号： 拼团才有");
            $table->integer('status')->comment("订单状态:客户未到店、已到店");
            $table->integer('payment_count')->nullable()->comment("支付金额");
            $table->integer('payment_status')->nullable()->comment("支付状态0,1");
            $table->json('info')->nullable()->comment("详细信息");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('orders');
    }
}
