<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LinkedinController extends Controller
{
    //
    CONST DRIVER_TYPE = 'linkedin';

    public function handleRedirect()
    {
        return Socialite::driver(static::DRIVER_TYPE)->redirect();
    }

    public function handleCallback()
    {
        try {

            $user = Socialite::driver(static::DRIVER_TYPE)->user();

            $userExisted = User::where('email', $user->email)->first();

            if( $userExisted ) {

                Auth::login($userExisted);

                return redirect()->route('dashboard');

            } else {

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => static::DRIVER_TYPE,
                    'profile_photo' =>$user->getAvatar(),
//                    'password' => Hash::make($user->id)
                ]);

                Auth::login($newUser);

                return redirect()->route('dashboard');
            }


        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
