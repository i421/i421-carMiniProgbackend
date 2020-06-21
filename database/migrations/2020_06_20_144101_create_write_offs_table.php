<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWriteOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('write_offs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->comment('客户id');
            $table->integer('merchant_id')->unsigned()->comment('店家id');
            $table->string('content')->comment("核销明细");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // 外键关联
            $table->foreign('customer_id')
                ->references('id') ->on('customers')
                ->onUpdate('cascade');
            $table->foreign('merchant_id')
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
        Schema::dropIfExists('write_offs');
    }
}
