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

    public function getImgUrlAttribute($value)
    {
        return '/storage/'. $value;
    }

    public function getLicenseUrlAttribute($value)
    {
        return '/storage/'. $value;
    }
}
