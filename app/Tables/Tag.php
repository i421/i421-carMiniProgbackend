<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
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
	 * 汽车
	 */
	public function cars()
	{
		return $this->belongsToMany(Car::class);
	}
}
