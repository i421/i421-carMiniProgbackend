<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $appends = ['full_img'];

    public function getFullImgAttribute()
    {
        return url('/') . '/storage/' . $this->attributes['img'];
    }

    /**
     * 多对多关联 (相对关联)
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class)->withPivot('left_count', 'qr_code');
    }
}
