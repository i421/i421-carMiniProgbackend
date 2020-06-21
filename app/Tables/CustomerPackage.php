<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class CustomerPackage extends Model
{
    protected $table = "customer_package";
    /**
     * 禁止字段批量插入
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at',
    ];
}
