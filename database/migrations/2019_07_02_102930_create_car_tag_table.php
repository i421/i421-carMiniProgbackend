<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id')->index()->unsigned()->comment('汽车id');
            $table->integer('tag_id')->index()->unsigned()->comment('标签id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // 外键关联
            $table->foreign('car_id')
                ->references('id')->on('cars')
                ->onUpdate('cascade');

            $table->foreign('tag_id')
                ->references('id')->on('tags')
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
        Schema::dropIfExists('car_tag');
    }
}
