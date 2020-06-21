<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class WriteOff extends Model
{
    /**
     * 禁止字段批量插入
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at',
    ];
}
