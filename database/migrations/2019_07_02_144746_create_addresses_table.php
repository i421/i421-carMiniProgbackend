<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('division_code')->index()->comment("划分代号");
            $table->integer('division_level')->index()->comment("层级");
            $table->string('pinyin')->index()->comment("拼音");
            $table->string('division_name')->index()->comment("地区简体");
            $table->string('division_t_name')->index()->comment("地区繁体");
            $table->string('division_abb_name')->index()->comment("简称");
            $table->string('is_deleted')->comment("是否删除");
            $table->string('p_id')->index()->comment("父节点");
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
        Schema::dropIfExists('addresses');
    }
}
