<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
	protected $table = 'suppliers';
	protected $fillable = [
        'cate_id', 'name', 'email', 'phone', 'address'
    ];
}
