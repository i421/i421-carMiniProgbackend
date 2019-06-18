<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations. (角色表)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('名称');
            $table->string('display_en_name')->comment('角色英文名称');
            $table->string('display_zh_name')->comment('角色中文名称');
            $table->string('description')->nullable()->comment('角色描述');
            $table->json('info')->nullable()->comment('角色信息');
            $table->boolean('status')->default(1)->comment('角色状态');
            $table->softDeletes()->comment('软删除');
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
        Schema::dropIfExists('roles');
    }
}
