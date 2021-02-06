<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table    = 'countries';
	protected $fillable = [
		'country_name_ar',
		'country_name_en',
		'mob',
		'currency',
		'code',
		'logo',
	];

	
    public function cities()
    {
        return $this->hasMany('App\City');
	}
	
	public function states()
    {
        return $this->hasMany('App\State');
	}

	public function malls() {
		return $this->hasMany('App\Mall', 'country_id', 'id');
	}

}
