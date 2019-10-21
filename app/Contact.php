<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	protected $fillable = [
		'user_id',
		'type',
		'first_name',
		'username',
		'last_online',
		'access_hash',
		'phone',
		'dup'
	];
}
