<?php

namespace App\Tables\Traits;

/*
|--------------------------------------------------------------------------
| Info Traits
|--------------------------------------------------------------------------
|
| InfoTrait is used to format the info column in model.
*/

trait InfoTrait
{
    /**
     * Json2Array
     *
     * @param string $value
     * @return mixed
     */
    public function getInfoAttribute($value)
    {
        $temp = json_decode($value, true);

        if (isset($temp['id_card_front_path'])) {
            $temp['id_card_front_path'] = '/storage/'. $temp['id_card_front_path'];
            $temp['full_id_card_front_path'] = '/storage/'. $temp['id_card_front_path'];
        }
        if (isset($temp['id_card_back_path'])) {
            $temp['id_card_back_path'] = '/storage/'. $temp['id_card_back_path'];
            $temp['full_id_card_back_path'] = url('/') . '/storage/'. $temp['id_card_back_path'];
        }
        if (isset($temp['driver_license'])) {
            $temp['driver_license'] = '/storage/'. $temp['driver_license'];
            $temp['full_driver_license'] = url('/') . '/storage/'. $temp['driver_license'];
        }
        if (isset($temp['bank_card'])) {
            $temp['bank_card'] = '/storage/'. $temp['bank_card'];
            $temp['full_bank_card'] = url('/') . '/storage/'. $temp['bank_card'];
        }

        if (isset($temp['carousel'])) {
            foreach ($temp['carousel'] as &$atom) {
                $temp['full_carousel'][] = url('/') . '/'. $atom;
            }
        }

        return $temp;
    }

    /**
     * Array2json
     *
     * @param array $value
     */
    public function setInfoAttribute(array $value)
    {
        $this->attributes['info'] = json_encode($value);
    }
}
