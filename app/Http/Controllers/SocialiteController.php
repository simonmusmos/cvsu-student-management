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
        return Socialite::driver($type)->redirect();
    }
}
