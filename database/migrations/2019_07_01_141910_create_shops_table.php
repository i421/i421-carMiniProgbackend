<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //门店管理
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->comment("用户ID");
            $table->string('name')->index()->comment("店铺名称");
            $table->string('phone')->nullable()->index()->comment("手机号");
            $table->json('province')->nullable()->comment("省份");
            $table->json('city')->nullable()->comment("城市");
            $table->json('area')->nullable()->comment("区");
            $table->string('img_url')->nullable()->comment("封面图");
            $table->string('license_url')->nullable()->comment("营业执照");
            $table->string('detail_address')->comment("详细地址");
            $table->string('lat')->nullable()->comment("经度");
            $table->string('lng')->nullable()->comment("纬度");
            $table->json('info')->nullable()->comment("其他信息");
            $table->softDeletes()->comment("软删除");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('shops');
    }
}
