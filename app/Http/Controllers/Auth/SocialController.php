<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

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
        $email = $socialUser->getEmail();

        if (! $email && $provider === 'github') {
            $email = $socialUser->id.'+'.$socialUser->getNickname().'@users.noreply.github.com';
        }

        $user = User::where($idField, $socialUser->id)->first();

        if (!$user) {
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            $user->update([
                $idField => $socialUser->id,
                'github_token' => $provider === 'github' ? $socialUser->token : $user->github_token,
                'github_refresh_token' => $provider === 'github' ? $socialUser->refreshToken : $user->github_refresh_token,
            ]);
        } else {
            $user = User::create([
                $idField => $socialUser->id,
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $email,
                'password' => bcrypt(Str::random(16)),
                'github_token' => $provider === 'github' ? $socialUser->token : null,
                'github_refresh_token' => $provider === 'github' ? $socialUser->refreshToken : null,
            ]);
        }

        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}
