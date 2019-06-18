<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations. (权限表)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('超链接');
            $table->string('display_en_name')->comment('菜单英文名');
            $table->string('display_zh_name')->comment('菜单中文名');
            $table->string('icon')->nullable()->comment('图标');
            $table->integer('pid')->default(0)->comment('父节点');
            $table->boolean('is_menu')->default(1)->comment('是否菜单');
            $table->integer('order')->default(1)->comment('排序');
            $table->integer('status')->default(1)->comment('权限状态');
            $table->string('description')->nullable()->comment('权限描述');
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
        Schema::dropIfExists('permissions');
    }
}
