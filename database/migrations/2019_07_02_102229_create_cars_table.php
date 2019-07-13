<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //汽车表
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->comment("汽车名称");
            $table->string('guide_price')->comment("汽车指导价");
            $table->string('final_price')->comment("落地价、成交价");
            $table->string('car_price')->comment("裸车价");
            $table->string('remarks')->nullable()->comment("备注");
            $table->json('info')->nullable()->comment("详细信息");
            $table->softDeletes()->comment("软删除");
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
        Schema::dropIfExists('cars');
    }
}
