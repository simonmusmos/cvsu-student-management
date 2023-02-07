<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class UserController extends Controller
{
    private $status_code    =        200;
    public function userLogin(Request $request) {
        // return 123;
        // $credentials = $request->getCredentials();
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            if ($user->user_type_id == 2) {
                $token =  $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    ]
                    , $this->status_code);
            }
            else{
                Auth::logout(); 
                return response()->json(['error'=>'Unauthorised'], 401);
            }
            
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    // ------------------ [ User Detail ] ---------------------
    public function userDetail(Request $request) {
        return $request->user();
    }

    public function userLogout(Request $request) {
        Auth::logout(); 
        return response()->json(['message'=>'Done'], 200);
    }
}
