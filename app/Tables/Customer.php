<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
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

    /*
     * 拼团要求
     */
    public function scopeCanGroup($query)
    {
        return $query->where(function ($query) {
            $query->whereNotNull('id_card')
                ->whereNotNull('driver_license');
        });
    }
}
