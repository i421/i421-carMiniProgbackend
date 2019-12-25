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
            $table->string('uuid')->index()->unique()->comment('系统唯一标识符');
            $table->string('openid')->index()->unique()->comment('微信唯一标志符');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('phone')->index()->unique()->nullable()->comment('手机号');
            $table->integer('gender')->nullable()->comment('性别');
            $table->string('country')->index()->nullable()->comment('国家');
            $table->string('province')->index()->nullable()->comment('省份');
            $table->string('city')->index()->nullable()->comment('城市');
            $table->string('area')->nullable()->comment('区');
            $table->string('detail_address')->nullable()->comment('详细地址');
            $table->string('customize_address')->nullable()->comment('自定义地址');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('qr_code')->unique()->nullable()->comment('二维码');
            $table->string('recommend_count')->default(0)->comment('推荐人数');
            $table->string('recommender')->nullable()->comment('推荐人用户id');
            $table->integer('auth')->default(0)->comment('状态: 待审核，已审核');
            $table->integer('type')->default(1)->comment('普通用户1/经纪人2');
            $table->integer('type_auth')->default(0)->comment('经纪人审核');
            $table->integer('score')->default(0)->comment('经纪人才有积分');
            $table->integer('is_seller')->default(0)->comment('是否是销售 => 此字段无用三期改成核销判断字段，1可以核销');
            $table->integer('status')->default(1)->comment('账户是否正常使用');
            $table->json('info')->nullable()->comment('其他信息[身份证正反,银行卡,驾驶证正反,姓名,身份证号]');
            $table->json('broker_info')->nullable()->comment('经纪人[身份证正反,银行卡,驾驶证正反,姓名,身份证号]');
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
