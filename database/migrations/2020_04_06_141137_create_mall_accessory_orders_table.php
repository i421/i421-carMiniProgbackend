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
            $table->integer("status")->comment("订单状态: 1待付款|2待发货|3已收货|4已完成");
            $table->string("mall_accessory_id")->nullable()->comment("配件id: 配件id逗号隔开");
            $table->string("mall_accessory_count")->nullable()->comment("配件销量: 配件数量逗号隔开");
            $table->integer("mall_address_id")->comment("收货地址id");
            $table->string("express_number")->nullable()->comment("快递单号");
            $table->string("append")->nullable()->comment("附加消息:规格等");
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
