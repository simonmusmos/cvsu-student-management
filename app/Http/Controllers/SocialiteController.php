<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Socialite;

class SocialiteController extends Controller
{
    public function index()
    {
        return view('oauth.index');
    }

    public function redirect($type)
    {
        if ($type == 'linkedin') {
            return Socialite::driver($type)->scopes(['r_liteprofile', 'r_emailaddress'])->stateless()->redirect();
        }
        return Socialite::driver($type)->redirect();
    }

    public function callback($type)
    {
        // dd(Socialite::driver($type)->user());
        try {
     
            $user = Socialite::driver($type)->user();
      
            dd($user);
            $linkedinUser = User::where('oauth_id', $user->id)->first();
      
            if($linkedinUser){
      
                Auth::login($linkedinUser);
     
                return redirect('/dashboard');
       
            }else{
                $user = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => 'linkedin',
                    'password' => encrypt('admin12345')
                ]);
     
                Auth::login($user);
      
                return redirect('/dashboard');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
