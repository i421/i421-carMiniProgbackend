<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerRechargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //积分充值
        Schema::create('customer_recharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->comment('客户id');
            $table->integer('score')->comment('积分');
            $table->string('content')->nullable()->comment('加分缘由');
            $table->string('append')->nullable()->comment('其他');
            $table->integer('status')->default(0)->comment('未打款');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // 外键关联
            $table->foreign('customer_id')
                ->references('id') ->on('customers')
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
        Schema::dropIfExists('customer_recharges');
    }
}
