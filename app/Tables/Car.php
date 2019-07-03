<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
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
	 * 标签
	 */
	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}
}
