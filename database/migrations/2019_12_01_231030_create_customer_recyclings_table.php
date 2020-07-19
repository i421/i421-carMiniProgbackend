<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerRecyclingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //积分回收
        Schema::create('customer_recyclings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->comment('客户id');
            $table->integer('score')->comment('积分');
            $table->integer('money')->default(0)->comment('钱');
            $table->integer('status')->default(0)->comment('未打款');
            $table->string('append')->nullable()->comment('其他');
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
        Schema::dropIfExists('customer_recyclings');
    }
}
