<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //系统消息管理
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable()->comment("标题");
            $table->longText('content')->nullable()->comment("内容");
            $table->integer('status')->default(0)->comment("是否已读");
            $table->datetime('start_time')->nullable()->comment("消息发布时间");
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
        Schema::dropIfExists('messages');
    }
}
