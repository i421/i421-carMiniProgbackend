<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment("标题");
            $table->longText('content')->nullable()->comment("内容");
            $table->datetime('publish_at')->nullable()->comment("发布时间");
            $table->integer('customer_id')->unsigned()->comment("客户ID");
            $table->json('imgs')->nullable()->comment("添加图片");
            $table->integer('like')->default(0)->comment("点赞数");
            $table->integer('status')->default(1)->comment("审核: 1通过 0 待审核 2 禁止");
            $table->integer('top')->default(0)->comment("是否置顶");
            $table->json('like_detail')->comment("点赞明细");
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
        Schema::dropIfExists('forums');
    }
}
