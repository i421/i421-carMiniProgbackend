<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class ShopSecondHandCar extends Model
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
     * Json2Array
     *
     * @param string $value
     */
    public function getImgAttribute($value)
    {
        if (is_null($value)) {
            $temp = [];
        } else {
            $arr = json_decode($value, true);

            $temp = [];
            foreach ($arr as &$atom) {
                $temp[] = url('/') . '/'. $atom;
            }
        }

        return $temp;
    }

    /**
     * Array2json
     *
     * @param array $value
     */
    public function setImgAttribute(array $value)
    {
        $this->attributes['img'] = json_encode($value);
    }
}
