<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class MallAccessoryOrder extends Model
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

    public function getMallAccessoryIdAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        $arr = explode(',', $value);

        return $arr;
    }

    public function getMallAccessoryCountAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        $arr = explode(',', $value);

        return $arr;
    }
}
