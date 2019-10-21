<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HSN extends Model
{
	protected $fillable = [
		'user_id',
		'type',
		'first_name',
		'username',
		'last_online',
		'access_hash',
		'phone',
	];
}
