<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use InfoTrait, SoftDeletes;

    /**
     * 禁止字段批量插入
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at',
    ];

	/**
	 * 获取该用户拥有的门店
	 */
	public function user()
	{
		return $this->belongsToMany(User::class);
	}

    //修改封面图地址
    public function getImgUrlAttribute($value)
    {
        return '/storage/'. $value;
    }

    //修改营业执照地址
    public function getLicenseUrlAttribute($value)
    {
        return '/storage/'. $value;
    }

    //修改省份
    public function getProvinceAttribute($value)
    {
        return json_decode($value, true);
    }

    //修改省份
    public function setProvinceAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['province'] = json_encode($value);
        } else {
            $this->attributes['province'] = $value;
        }
    }

    //修改市
    public function getCityAttribute($value)
    {
        return json_decode($value, true);
    }

    //修改市
    public function setCityAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['city'] = json_encode($value);
        } else {
            $this->attributes['city'] = $value;
        }
    }


    //修改区域
    public function getAreaAttribute($value)
    {
        return json_decode($value, true);
    }

    //修改区域
    public function setAreaAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['area'] = json_encode($value);
        } else {
            $this->attributes['area'] = $value;
        }
    }
}
