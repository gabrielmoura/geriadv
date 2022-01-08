<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialiteController
 * @package App\Http\Controllers\Auth
 */
class SocialiteController extends Controller
{

    public function redirect($slug, $parse = [])
    {
        return Socialite::driver($slug)->redirect()->with($parse) ?? abort(401);
    }


    public function callback($slug)
    {
        $user = Socialite::driver($slug)->user();
        $userSocial = UserSocial::whereSocialId($user->id)->firstOrCreate([
            'user_id' => auth()->id(),
            'drive' => $slug,

            // OAuth 2.0 providers...
            'token' => $user->token,
            'refreshToken' => $user->refreshToken,
            'expiresIn' => $user->expiresIn,

            // OAuth 1.0 providers...
            '$token' => $user->token,
            '$tokenSecret' => $user->tokenSecret,

            // All providers...
            'socialId' => $user->getId(),
            'nickname' => $user->getNickname(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'avatar' => $user->getAvatar(),
        ]);
        if (Auth::loginUsingId($userSocial->user_id)) return redirect()->route('redirDASH');
        return abort(401);
    }

    public function callbackCreateUser($slug)
    {
        $social = Socialite::driver($slug)->user();
        $user = User::firstOrCreate([
            'email' => $social->getEmail()
        ], [
            'name' => $social->getName(),
            'password' => Hash::make(Str::random(24)),
        ]);
        $userSocial = UserSocial::whereSocialId($user->id)->firstOrCreate([
            'user_id' => $user->id,
            'drive' => $slug,

            // OAuth 2.0 providers...
            'token' => $social->token,
            'refreshToken' => $social->refreshToken,
            'expiresIn' => $social->expiresIn,

            // OAuth 1.0 providers...
            '$token' => $social->token,
            '$tokenSecret' => $social->tokenSecret,

            // All providers...
            'socialId' => $social->getId(),
            'nickname' => $social->getNickname(),
            'name' => $social->getName(),
            'email' => $social->getEmail(),
            'avatar' => $social->getAvatar(),
        ]);

        if (Auth::loginUsingId($user->id, true)) return redirect()->route('redirDASH');
        return abort(401);
    }
}
