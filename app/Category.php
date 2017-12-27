<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

	protected $fillable = [
        'name', 'alias', 'parent_id', 'keywords', 'description'
    ];

    public function products(){
    	return $this->hasMany('App\Product', 'cate_id', 'id');
    }
}
