<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
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

	/**
	 * 标签
	 */
	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}
}
