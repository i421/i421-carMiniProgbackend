<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
	/**
	 * The guarded attributes on the model.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'secret',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'personal_access_client' => 'bool',
		'password_client' => 'bool',
		'revoked' => 'bool',
	];
}
