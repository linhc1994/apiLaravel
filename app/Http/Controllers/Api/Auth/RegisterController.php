<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;

class RegisterController extends Controller
{

    use IssueTokenTrait;

    private $client;

    public function __construct(){
        $this->client = Client::where('name', 'LIKE', '%Password Grant Client')->first();
    }
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'level' => 'required'
        ]);

    	$user = User::create([
    		'name' => request('name'),
    		'email' => request('email'),
    		'password' => bcrypt('password'),
            'level'   => intval(request('level'))
    	]);
    	
    	return $this->issueToken($request, 'password');
    }
}
