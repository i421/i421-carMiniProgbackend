<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * 禁止字段批量插入
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at',
    ];

    //获取省份
    public function scopeGetProvinces($query)
    {
        return $query->where('division_level', '2');
    }

    //获取某一省份的市
    public function scopeGetCities($query, $id)
    {
        return $query->where([
            ['division_level', '3'],
            ['p_id', $id],
        ]);
    }

    //获取某一市的区或者镇
    public function scopeGetTowns($query, $id)
    {
        return $query->where([
            ['division_level', '4'],
            ['p_id', $id],
        ]);
    }
}
