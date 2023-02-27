<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Models\Email;

class AuthController extends Controller
{
	public function store(StoreAuthRequest $request)
	{
		$remember = $request['remember'];
		$attributes = $request->validated();

		$checkSecondaryEmails = Email::where('email', $attributes['email'])->first();
		if ($checkSecondaryEmails != null)
		{
			$attributes['email'] = $checkSecondaryEmails->user->email;
		}

		if (auth()->attempt($attributes, $remember))
		{
			$request->session()->regenerate();
			return response()->json(['message' => 'Successfully logged in' . $remember]);
		}

		return response()->json(['error' => 'user-not-found'], 401);
	}

	public function destroy()
	{
		auth()->logout();
		request()->session()->invalidate();
		request()->session()->regenerateToken();
		return response()->json(['message' => 'Logged out']);
	}
}
