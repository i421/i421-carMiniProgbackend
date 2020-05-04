<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class MallAccessory extends Model
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
    protected $appends = ['full_avatar'];

    //头图
    public function getAvatarAttribute($value)
    {
        return '/storage/'. $value;
    }

    public function getFullAvatarAttribute()
    {
        if (isset($this->attributes['avatar'])) {
            return url('/') . '/storage/' . $this->attributes['avatar'];
        } else {
            return '';
        }
    }
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
            foreach($temp as &$val) {
                if (!is_array($val['value'])) {
                    $val['value'] = explode(",", $val['value']);
                }
                if (!is_array($val['value'])) {
                    $val['value'] = explode("，", $val['value']);
                }
            }
            return $temp;
        }
    }

    public function setCarouselAttribute(array $value)
    {
        $this->attributes['carousel'] = json_encode($value);
    }

    public function getCarouselAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        $arr = json_decode($value, true);

        foreach ($arr as &$atom) {
            $atom = url('/') . '/' . $atom;
        }

        return $arr;
    }

    public function setImgsAttribute(array $value)
    {
        $this->attributes['imgs'] = json_encode($value);
    }

    public function getImgsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        $arr = json_decode($value, true);

        foreach ($arr as &$atom) {
            $atom = url('/') . '/' . $atom;
        }

        return $arr;
    }
}
