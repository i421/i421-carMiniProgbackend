<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forum_id')->unsigned()->comment("帖子ID");
            $table->integer('customer_id')->unsigned()->comment("客户ID");
            $table->longText('content')->nullable()->comment("内容");
            $table->integer('status')->default(1)->comment("审核");
            $table->integer('pid')->index()->default(0)->comment("上一级评论");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('forum_id')
                ->references('id')->on('forums')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('comments');
    }
}
