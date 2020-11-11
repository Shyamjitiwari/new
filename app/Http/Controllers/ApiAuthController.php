<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ApiAuthController extends Controller
{
    public function tokenLogin(Request $request)
    {
        if(Auth::attempt(['email' => $request->phoneNumber, 'password' => $request->password])){
            return json_encode(true);
        }
        return json_encode(false);
    }

    public function login(Request $request)
    {
        return $this->processLogin();
    }

    public function processLogin()
    {
        try
        {
            $http = new \GuzzleHttp\Client();

            $response = $http->post(env('APP_URL').'/oauth/token', [
                'form_params' => [
                    'grant_type' => Config::get('settings.passport.grant_type'),
                    'client_id' => Config::get('settings.passport.client_id'),
                    'client_secret' => Config::get('settings.passport.client_secret'),
                    'scope' => Config::get('settings.passport.scope'),
                    'username' => 'api_user@codewithus.com',
                    'password' => '123123123',
                ],
            ]);

            return $response->getBody();
        }
        catch (\GuzzleHttp\Exception\BadResponseException $e)
        {
            return response()->json(['data'=> $e->getCode(), 'message' => 'Something went wrong!', 'status'=>'error'],404);
        }
    }

    public function logout()
    {
        return Auth::user();
    }
}
