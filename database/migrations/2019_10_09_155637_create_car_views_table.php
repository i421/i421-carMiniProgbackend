<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_views', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id')->unsigned()->index()->comment("汽车ID");
            $table->integer('count')->default(0)->comment("汽车浏览量");
            $table->string('append')->nullable()->comment("其他");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('car_id')
                ->references('id')->on('cars')
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
        Schema::dropIfExists('car_views');
    }
}
