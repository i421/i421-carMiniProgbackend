<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
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

    /**
     * 多对多关联 (相对关联)
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
