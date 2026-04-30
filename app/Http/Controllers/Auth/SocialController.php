<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->user();
        $idField = $provider.'_id';

        $user = User::updateOrCreate([
            $idField => $socialUser->id,
        ], [
            'name' => $socialUser->getName() ?? $socialUser->getNickname(),
            'email' => $socialUser->getEmail(),
            'github_token' => $provider === 'github' ? $socialUser->token : null,
            'github_refresh_token' => $provider === 'github' ? $socialUser->refreshToken : null,
        ]);

        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}
