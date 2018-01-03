<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $table = "brands";

    protected $fillable = [
        'name', 'email', 'address', 'alias', 'parent_id', 'keywords', 'description'
    ];

    public function products(){
    	return $this->hasMany('App\Product', 'brand_id', 'id');
    }
}
