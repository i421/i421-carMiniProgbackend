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
            $table->integer('brand_id')->unsigned()->index()->comment("品牌名");
            $table->integer('type')->default(1)->index()->comment("现车1/拼团2");
            $table->integer('group_recommend')->default(0)->index()->comment("是否拼团推荐:0否/1是");
            $table->string('name')->index()->comment("汽车名称");
            $table->string('avatar')->nullable()->comment("汽车缩略图");
            $table->integer('guide_price')->comment("汽车指导价");
            $table->integer('final_price')->comment("落地价、成交价");
            $table->integer('car_price')->comment("裸车价");
            $table->integer('height')->default(50)->comment("权重");
            $table->integer('sale_num')->default(0)->comment("销售量");
            $table->integer('down_payment')->default(0)->comment("首付");
            $table->float('staging24', 8, 2)->default(0)->comment("分期24价格");
            $table->float('staging36', 8, 2)->default(0)->comment("分期36价格");
            $table->float('staging48', 8, 2)->default(0)->comment("分期48价格");
            $table->string('remarks')->nullable()->comment("备注 销售量");
            $table->json('model')->nullable()->comment("车型");
            $table->json('info')->nullable()->comment("详细信息");
            $table->integer('off')->default(0)->index()->comment("优惠");
            $table->integer('group_type')->default(0)->index()->comment("时间拼团1/数量拼团2");
            $table->integer('group_num')->default(1)->index()->comment("拼团数量");
            $table->integer('group_price')->default(0)->comment("拼团价");
            $table->integer('total_num')->default(0)->index()->comment("拼团总人数");
            $table->integer('current_num')->default(0)->index()->comment("拼团当前人数");
            $table->datetime('start_time')->nullable()->index()->comment("拼团开始时间");
            $table->datetime('end_time')->nullable()->index()->comment("拼团结束时间");
            $table->softDeletes()->comment("软删除");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('brand_id')
                ->references('id')->on('brands')
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
        Schema::dropIfExists('cars');
    }
}
