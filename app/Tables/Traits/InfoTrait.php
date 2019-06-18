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
        return json_decode($value, true);
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
