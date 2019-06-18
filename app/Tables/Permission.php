<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use InfoTrait, SoftDeletes;

    /**
     * 禁止字段批量插入
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at',
    ];
}
