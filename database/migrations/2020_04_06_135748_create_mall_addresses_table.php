<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMallAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mall_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('default')->default(0)->comment("默认");
            $table->string('name')->comment("姓名");
            $table->string('phone')->comment("手机号");
            $table->string('city')->comment("地图");
            $table->string('detail_address')->comment("详细地址");
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
        Schema::dropIfExists('mall_addresses');
    }
}
