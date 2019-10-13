<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class ShopRepair extends Model
{
    /**
     * 禁止字段批量插入
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at',
    ];

    public function getImgAttribute()
    {
        return url('/') . '/storage/' . $this->attributes['img'];
    }
}
