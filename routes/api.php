<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');

Route::middleware('web')->group(function () {
    Route::post('logout', 'Api\Auth\LoginController@logout');
    Route::get('posts', 'Api\PostController@index');
    Route::resource('brands', 'Api\BrandsController', 
    	[
    		'only' => ['index', 'show', 'store', 'update', 'destroy']	
		],
		[
			'except' => ['create', 'edit']
	    ]
	);
	Route::resource('categories', 'Api\CategoriesController', 
    	[
    		'only' => ['index', 'show', 'store', 'update', 'destroy']	
		],
		[
			'except' => ['edit']
	    ]
	);
	Route::resource('users', 'Api\UsersController', 
    	[
    		'only' => ['index', 'show', 'store', 'update', 'destroy']	
		],
		[
			'except' => ['edit']
	    ]
	);
	Route::resource('customers', 'Api\CustomersController', 
    	[
    		'only' => ['index', 'show', 'store', 'update', 'destroy']	
		],
		[
			'except' => ['edit']
	    ]
	);
	Route::resource('products', 'Api\ProductsController', 
    	[
    		'only' => ['index', 'show', 'store', 'update', 'destroy']	
		],
		[
			'except' => ['edit']
	    ]
	);
});
