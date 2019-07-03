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
            $table->string('name')->unique()->nullable()->comment('用户名');
            $table->string('phone')->unique()->nullable()->comment('手机号');
            $table->string('id_card')->unique()->comment('身份证');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('gender')->nullable()->comment('性别');
            $table->string('referrer')->nullable()->comment('推荐人open_id');
            $table->json('info')->nullable()->comment('其他信息');
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
