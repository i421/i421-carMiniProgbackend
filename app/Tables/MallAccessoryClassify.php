<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class MallAccessoryClassify extends Model
{
    //
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
    protected $appends = ['full_img'];

    public function getFullImgAttribute()
    {
        return url('/') . '/storage/' . $this->attributes['img'];
    }
}
