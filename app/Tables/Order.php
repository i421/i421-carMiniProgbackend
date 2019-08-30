<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use InfoTrait;

    /**
     * 禁止字段批量插入
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at',
    ];

    //单位转换
    public function getPaymentCountAttribute($value)
    {
        return bcdiv($value, 100, 2);
    }
}
