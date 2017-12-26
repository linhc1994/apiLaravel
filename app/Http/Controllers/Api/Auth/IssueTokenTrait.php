<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait{

	public function issueToken(Request $request, $grantType, $scope = "*"){

		$params = [
    		'grant_type' => $grantType,
    		'client_id' => $this->client->id,
    		'client_secret' => $this->client->secret,    		
    		'scope' => $scope
    	];

        if($grantType !== 'social'){
            $params['username'] = $request->username ?: $request->email;
            $params['password'] = $request->password;
        }
        //var_dump($this->client->id);die;

    	$request->request->add($params);

    	$proxy = Request::create('oauth/token', 'POST');

    	return Route::dispatch($proxy);
	}
}