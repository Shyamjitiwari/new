<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ProcessResponse;
use Illuminate\Support\Facades\Config;
use Psr\Http\Message\StreamInterface;
use App\Helper\LogActivity;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    use ProcessResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function authUser(Request $request)
    {
        $user = $request->user();
        $user['permissions'] = Auth::user()->role->permissions()->pluck('key');
        return $this->processResponse('success', 200, 'Logged In Successfully!', $user);
    }

    /**
     * @param Request $request
     * @return JsonResponse|StreamInterface
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        return $this->processLogin($request->input('email'), $request->input('password'));
    }

    /**
     * @param $email
     * @param $password
     * @return JsonResponse|StreamInterface
     */
    public function processLogin($email, $password)
    {

        if(Auth::attempt(['email'=>$email,'password'=>$password]))
        {

            try
            {
                $http = new \GuzzleHttp\Client();

                $response = $http->post('http://127.0.0.1:8001/oauth/token', [
                    'form_params' => [
                        'grant_type' => Config::get('settings.passport.grant_type'),
                        'client_id' => Config::get('settings.passport.client_id'),
                        'client_secret' => Config::get('settings.passport.client_secret'),
                        'scope' => Config::get('settings.passport.scope'),
                        'username' => $email,
                        'password' => $password,
                    ],
                ]);



                LogActivity::add(Auth::user(),'ActivityLabels::_LOGIN');

                return $response->getBody();
            }
            catch (\GuzzleHttp\Exception\BadResponseException $e)
            {
                return $this->processResponse('error',404,'Something went wrong!',$e->getCode());
            }
        }
        else
        {
            return $this->processResponse('error',404,'Username or password incorrect!',null);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        Helper::revokeToken(Auth::user());

        LogActivity::add(Auth::user(),'ActivityLabels::_LOGOUT');

        return $this->processResponse('success',200,'Logged Out Successfully!', null);
    }

    /**
     * @return JsonResponse
     */
    public function userPermissions()
    {
        $allPermissions = \App\Permission::all();

        $permissions = Auth::user()->role->permissions()->get();

        $permission = array();

        foreach($allPermissions as $j)
        {
            $permission[$j->key] = false;
        }

        foreach($permissions as $p)
        {
            if(array_key_exists($p->key,$permission))
            {
                $permission[$p->key] = true;
            }
        }

        // setting and sending role as key and role id pair
        $permission['role'] = Auth::user()->role_id;
        $permission['role_name'] = Auth::user()->role->name;

        return $this->processResponse('success', 200, null, $permission);
    }

    public function getTeam()
    {
        $user = Auth::user();
        $teams = $user->team;

        return $this->processResponse('success', 200, null, $teams);
    }

    public function impersonate(Request $request)
    {
        $this->logout();

        $user = User::find($request->input('user_id'));
        $token = $user->createToken('Token Name')->accessToken;

        return $this->processResponse('success', 200, null, ['access_token' => $token]);
    }
}
