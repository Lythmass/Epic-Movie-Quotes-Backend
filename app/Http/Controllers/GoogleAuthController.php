<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function index()
    {
        return Socialite::with('google')->stateless()->redirect();
    }

    public function store()
    {
        $googleUser = Socialite::with('google')->stateless()->user();
        $isRegisteredNormally = User::where('email', $googleUser->email)->where('google_id', null)->exists();
        if ($isRegisteredNormally) {
            return abort(401);
        }
        $user = User::updateOrCreate(
            ['google_id' => $googleUser->id],
            [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => '',
            ]
        );

        if ($user->email_verified_at === null) {
            $user->email_verified_at = now();
        }
        $user->save();

        auth()->login($user);
        return redirect(config('app.front_app_url'));
    }
}
