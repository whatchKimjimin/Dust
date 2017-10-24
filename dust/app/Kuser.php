<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuser extends Model
{
	public $timestamps = false;
    protected $fillable = ['username', 'useremail', 'userpass'];
}
