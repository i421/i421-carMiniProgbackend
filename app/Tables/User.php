<?php

namespace App\Tables;

use App\Tables\Traits\InfoTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/*
|------------------------------------------------------------------------------
| EntrustUserTrait
|------------------------------------------------------------------------------
|
| add methods roles(), hasRole($name), can($permission), and ability($roles, $permissions, $options)
*/

class User extends Authenticatable
{
    use EntrustUserTrait, HasApiTokens, InfoTrait, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'info',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 一对多关联
     */
    public function platforms()
    {
        return $this->hasMany(Platform::class);
    }

    /**
     * Passport multiple type login
     *
     * @param $identifier
     * @return mixed
     */
    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)
            ->orWhere('name', $identifier)
            ->orWhere('phone', $identifier)
            ->first();
    }

    /**
     * 一对多关联
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * 一对多关联
     */
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    /**
     * 一对多关联
     */
    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }
}
