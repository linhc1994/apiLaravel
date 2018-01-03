<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;

class LoginController extends Controller
{
	use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::where('name', 'LIKE', '%Password Grant Client')->first();
	}
    public function login(Request $request){
    	$this->validate($request, [
    		'username' => 'required',
    		'password' => 'required'
    	]);

    	return $this->issueToken($request, 'password');
    }

    public function refresh(Request $request){
		$this->validate($request, [
    		'refresh_token' => 'required'
    	]);

        return $this->issueToken($request, 'refresh_token');
    }

    public function logout(Request $request){

    	$accessToken = Auth::user()->token();

    	DB::table('oauth_refresh_tokens')
    		->where('access_token_id', $accessToken)
    		->update(['revoked' => true]);

    	$accessToken->revoke();

    	return response()->json([], 204);
    }
}
