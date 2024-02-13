<?php

namespace HamiltonSC\Auth\App\Http\Controllers;

use AMoschou\RemoteAuth\App\Http\Controllers\LoginController as BaseLoginController;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Support\Login as LoginSupport;

class GoogleLoginController extends BaseLoginController
{
    protected function authenticated(Request $request): RedirectResponse
    {
        $with = [
            'access_type' => 'offline',
            'include_granted_scopes' => 'true',
            'response_type' => 'code'
        ];

        if (! is_null(config('services.google.login_hint'))) {
            $with['login_hint'] = Auth::user()->getProfile()['email'];
        }

        if (! is_null(config('services.google.hd'))) {
            $with['hd'] = config('services.google.hd');
        }

        $scopes = config('services.google.scopes') ?? [];

        $hasGoogleEmail = ! is_null(Auth::user()->getProfile()['email']);

        if ($hasGoogleEmail) {
            return Socialite::driver('google')->with($with)->scopes($scopes)->redirect();
        } else {
            return $this->calledback($request);
        }
    }

    public function callback(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $socialite = $user->socialite;
        $socialite['google'] = Socialite::driver('google')->user();
        $user->socialite = $socialite;
        $user->save();

        return $this->calledback($request);
    }

    private function calledback(Request $request): RedirectResponse
    {
        $intended = $request->session()->get('intended');

        $request->session()->forget('intended');

        return redirect()->intended($intended);
    }
}
