<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFightingGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //拼团组
        Schema::create('fighting_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id')->unsigned()->index()->comment("拼团车辆");
            $table->integer('total_num')->index()->comment("拼团总人数");
            $table->integer('currnet_num')->index()->comment("拼团当前人数");
            $table->integer('group_price')->comment("拼团价");
            $table->integer('last_price')->comment("落地价");
            $table->datetime('start_time')->nullable()->index()->comment("拼团开始时间");
            $table->datetime('end_time')->nullable()->index()->comment("拼团结束时间");
            $table->integer('handling_fee')->default(0)->comment("手续费");
            $table->integer('insurance')->default(0)->comment("保险费");
            $table->json('info')->nullable()->comment("其他信息");
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
        Schema::dropIfExists('fighting_groups');
    }
}
