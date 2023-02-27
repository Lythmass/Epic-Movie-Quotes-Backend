<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
	public function send(Request $request)
	{
		app()->setLocale($request['locale']);
		$request->validate(['email' => ['required', 'email', 'exists:users,email']]);
		$status = Password::sendResetLink($request->only('email'));

		return
			$status === Password::RESET_LINK_SENT
			? response()->json(['message' => __($status)])
			: response()->json(['message' => __($status)]);
	}

	public function update(StorePasswordResetRequest $request)
	{
		$request->validated();
		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) {
				$user->forceFill([
					'password' => bcrypt($password),
				])->setRememberToken(Str::random(60));
				$user->save();
				event(new PasswordReset($user));
			}
		);
		return
			$status === Password::RESET_LINK_SENT
			? response()->json(['message' => __($status)])
			: response()->json(['message' => __($status)]);
	}
}
