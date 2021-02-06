<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MallProduct extends Model {
	protected $table    = 'mall_products';
	protected $fillable = [
		'product_id',
		'mall_id',
	];

	public function mall() {
		return $this->hasOne('App\Mall', 'id', 'mall_id');
	}
}
