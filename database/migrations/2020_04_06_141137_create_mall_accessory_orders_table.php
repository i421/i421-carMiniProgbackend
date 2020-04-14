<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMallAccessoryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mall_accessory_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("customer_id")->comment("客户ID");
            $table->string("uuid")->index()->comment("订单号");
            $table->integer("pay_price")->comment("支付金额");
            $table->integer("pay_type")->comment("支付类型");
            $table->integer("status")->comment("订单状态: 待付款|待收货|已完成");
            $table->integer("mall_accessory_id")->comment("配件id");
            $table->integer("mall_address_id")->comment("收货地址id");
            $table->string("express_number")->nullable()->comment("快递单号");
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
        Schema::dropIfExists('mall_accessory_orders');
    }
}
