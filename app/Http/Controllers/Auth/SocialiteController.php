<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserSocial;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialiteController
 * @package App\Http\Controllers\Auth
 */
class SocialiteController extends Controller
{
    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|void
     */
    public function redirect($slug)
    {
        return Socialite::driver($slug)->redirect() ?? abort(401);
    }

    /**
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse|void
     */
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
}
