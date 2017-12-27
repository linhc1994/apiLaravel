<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'products';

    public function category(){
    	return $this->belongsTo('App\Category', 'cate_id', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Brands', 'brand_id', 'id');
    }

    public function productImages(){
    	return $this->hasMany('App\ProductImage', 'product_id', 'id');
    }

    public function orderDetails(){
    	return $this->hasMany('App\OrderDetail','product_id','id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
