<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = 'customers';

    public function payments(){
    	return $this->hasMany('App\Payment', 'customer_id', 'id');
    }

    public function orders(){
    	return $this->hasMany('App\Order', 'customer_id', 'id');
    }
}
