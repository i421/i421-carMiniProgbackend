<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单
        Schema::create('package_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_num')->unique()->index()->comment("订单编号");
            $table->integer('package_id')->unsigned()->comment("套餐ID");
            $table->integer('customer_id')->unsigned()->comment("客户ID");
            $table->integer('pay_log_id')->default(0)->comment("预支付订单id");
            $table->float('payment_count')->nullable()->comment("支付金额");
            $table->integer('payment_status')->nullable()->comment("支付状态0,1");
            $table->json('info')->nullable()->comment("详细信息");
            $table->softDeletes()->comment('软删除');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('customer_id')
                ->references('id')->on('customers')
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
        Schema::dropIfExists('package_orders');
    }
}
