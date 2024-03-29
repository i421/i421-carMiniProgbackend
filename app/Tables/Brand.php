<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * 禁止字段批量插入
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at',
    ];

    /**
     * 添加字段
     */
    protected $appends = ['full_logo'];

    public function getLogoAttribute($value)
    {
        return '/storage/'. $value;
    }

    public function getFullLogoAttribute()
    {
        return url('/') . '/storage/' . $this->attributes['logo'];
    }
}
