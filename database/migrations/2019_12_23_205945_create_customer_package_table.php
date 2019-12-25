<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_package', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->comment('用户id');
            $table->integer('package_id')->unsigned()->comment('套餐id');
            $table->integer('left_count')->comment('剩余保养次数');
            $table->string('qr_code')->comment('二维码');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // 外键关联
            $table->foreign('customer_id')
                ->references('id') ->on('customers')
                ->onUpdate('cascade');

            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
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
        Schema::dropIfExists('customer_package');
    }
}
