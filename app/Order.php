<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'orders';

    public function customer(){
    	return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }

    public function orderDetails(){
    	return $this->hasMany('App\OrderDetail', 'order_id', 'id');
    }

    public function payment(){
    	return $this->belongsTo('App\Payment', 'payment_id', 'id');
    }
}

