<?php

namespace App\Http\Controllers\Api\V1\Doctor\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Sanctum\PersonalAccessToken;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	public function logout(){
        $accessToken = request()->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);
        if(!$token){
            return response()->json([
                'error'=>true,
                'message'=>'Unknown Error!'
            ],422);
        }
        $user=$token->tokenable_type::find($token->tokenable_id);
        $revoke=$user->tokens()->delete();
        if(!$revoke){
            return response()->json([
                'error'=>true,
                'message'=>'Unknown Error!'
            ],422);
        }
        activity()->causedBy($user)->performedOn($user)->event('logout')
                  ->useLog('logout')
                  ->log('Logout, User logout from system');
        activity()->causedBy($user)->performedOn($user)->event('logout')->useLog('location')
                  ->withProperties(['latitude'=>request()->latitude,'longitude'=>request()->longitude,'device_id' => request()->device_id])  
                  ->log('Logout, User logout from system');

        return response()->json([
            'success'=>true,
            'message'=>'Logout successfully'
        ]);
    }
	
	
}
