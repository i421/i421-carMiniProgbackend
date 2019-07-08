<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use InfoTrait;

    /**
     * 禁止字段批量插入
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at',
    ;

	/**
	 * 获取该用户拥有的门店
	 */
	public function user()
	{
		return $this->belongsToMany(User::class);
	}
}
