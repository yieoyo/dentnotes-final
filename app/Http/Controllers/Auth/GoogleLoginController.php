<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            Auth::login($user);
            if($user->isAdmin()){
                return redirect(RouteServiceProvider::DASHBOARD);
            }
            return redirect(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            // Handle exceptions, log errors, or redirect to a failure page.
            return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
        }
    }
}
