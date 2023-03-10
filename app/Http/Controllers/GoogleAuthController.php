<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
	public function index()
	{
		return Socialite::with('google')->stateless()->redirect();
	}

	public function store()
	{
		$googleUser = Socialite::with('google')->stateless()->user();
		$isRegistered = User::where('email', $googleUser->email)->first();
		if ($isRegistered !== null && $isRegistered->google_id == null)
		{
			return abort(401);
		}
		$username = $isRegistered !== null ? $isRegistered->name : $googleUser->name;
		$username = Str::replace(' ', '1', $username);
		if (strlen($username) > 15)
		{
			$username = Str::substr($username, 0, 16);
		}
		$username = Str::of($username)->lower();
		$user = User::updateOrCreate(
			['google_id' => $googleUser->id],
			[
				'name'            => $username,
				'email'           => $googleUser->email,
				'password'        => bcrypt(''),
			]
		);
		$user->profile_picture = $googleUser->getAvatar();
		if ($user->email_verified_at === null)
		{
			$user->email_verified_at = now();
		}

		$user->save();
		return redirect(config('app.front_app_url') . '?google_id=' . $googleUser->id);
	}

	public function login(Request $request)
	{
		$googleId = $request['googleId'];
		$user = User::where('google_id', $googleId)->first();
		$attributes = [
			'email'    => $user->email,
			'password' => '',
		];
		if (auth()->attempt($attributes))
		{
			$request->session()->regenerate();
			return response()->json(['message' => 'Successfully logged in!']);
		}
		return response()->json(['error' => 'user-not-found'], 401);
	}
}
