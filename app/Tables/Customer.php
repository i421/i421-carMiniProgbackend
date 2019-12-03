<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
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

    // 小程序码
    public function getQrCodeAttribute($value)
    {
        return '/storage/'. $value;
    }

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

    /*
     * 普通客户
     */
    public function scopeIsNormal($query)
    {
        return $query->where('type', '=', 1);
    }

    /*
     * 经纪人
     */
    public function scopeIsBroker($query)
    {
        return $query->where('type', '=', 2);
    }

    /**
     * Json2Array
     *
     * @param string $value
     * @return mixed
     */
    public function getTypeInfoAttribute($value)
    {
        $temp = json_decode($value, true);

        if (isset($temp['id_card_front_path'])) {
            $temp['id_card_front_path'] = '/storage/'. $temp['id_card_front_path'];
            $temp['full_id_card_front_path'] = url('/') . '/' . $temp['id_card_front_path'];
        }
        if (isset($temp['id_card_back_path'])) {
            $temp['id_card_back_path'] = '/storage/'. $temp['id_card_back_path'];
            $temp['full_id_card_back_path'] = url('/') . '/'. $temp['id_card_back_path'];
        }
        if (isset($temp['bank_card'])) {
            $temp['bank_card'] = '/storage/'. $temp['bank_card'];
            $temp['full_bank_card'] = url('/') . '/'. $temp['bank_card'];
        }
        return $temp;
    }

    /**
     * Array2json
     *
     * @param array $value
     */
    public function setTypeInfoAttribute(array $value)
    {
        $this->attributes['type_info'] = json_encode($value);
    }
}
