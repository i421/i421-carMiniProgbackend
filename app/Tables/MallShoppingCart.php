<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class MallShoppingCart extends Model
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
     * Json2Array
     *
     * @param string $value
     * @return mixed
     */
    public function getDetailAttribute($value)
    {
        if ($value == 'null') {
            return [];
        } else if ($value == null) {
            return [];
        } else {
            $temp = json_decode($value, true);
            return $temp;    
        }
    }

    public function setDetailAttribute(array $value)
    {
        $this->attributes['detail'] = json_encode($value);
    }
}
