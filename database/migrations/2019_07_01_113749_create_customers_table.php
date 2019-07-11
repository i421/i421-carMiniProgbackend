<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->unique()->comment('微信唯一标志符');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('phone')->unique()->nullable()->comment('手机号');
            $table->json('id_card')->nullable()->comment('身份证正反');
            $table->json('bank_card')->nullable()->comment('银行卡');
            $table->json('driver_license')->nullable()->comment('驾驶证正反');
            $table->json('qr_code')->unique()->nullable()->comment('二维码');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('recommend_count')->default(0)->comment('推荐人数');
            $table->string('recommender')->nullable()->comment('推荐人open_id');
            $table->json('info')->nullable()->comment('其他信息');
            $table->integer('status')->default(1)->comment('状态: 待审核，已审核');
            $table->softDeletes();
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
        Schema::dropIfExists('customers');
    }
}
