<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $table = 'payments';

    public function customer(){
    	return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }

    public function orders(){
    	return $this->hasMany('App\Order', 'payment_id', 'id');
    }
}
