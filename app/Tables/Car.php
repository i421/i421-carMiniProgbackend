<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
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
     * 添加字段
     */
    protected $appends = ['full_avatar'];

	/**
	 * 标签
	 */
	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}

    //头图
    public function getAvatarAttribute($value)
    {
        return '/storage/'. $value;
    }

    public function getFullAvatarAttribute()
    {
        return url('/') . '/storage/' . $this->attributes['avatar'];
    }

    /**
     * Json2Array
     *
     * @param string $value
     * @return mixed
     */
    public function getModelAttribute($value)
    {
        if ($value == 'null') {
            return [];
        } else if ($value == null) {
            return [];
        } else {
            $temp = json_decode($value, true);
            return $temp;    
        }
    }

    public function setModelAttribute(array $value)
    {
        $this->attributes['model'] = json_encode($value);
    }
}
