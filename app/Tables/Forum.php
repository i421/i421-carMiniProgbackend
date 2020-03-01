<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
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
     * @return mixed
     */
    public function getImgsAttribute($value)
    {
        $temp = json_decode($value, true);
        return $temp;
    }

    /**
     * Array2json
     *
     * @param array $value
     */
    public function setImgsAttribute(array $value)
    {
        $this->attributes['imgs'] = json_encode($value);
    }

    /**
     * Json2Array
     *
     * @param string $value
     * @return mixed
     */
    public function getLikeDetailAttribute($value)
    {
        $temp = json_decode($value, true);
        return $temp;
    }

    /**
     * Array2json
     *
     * @param array $value
     */
    public function setLikeDetailAttribute(array $value)
    {
        $this->attributes['like_detail'] = json_encode($value);
    }
}
