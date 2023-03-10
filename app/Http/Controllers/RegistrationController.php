<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
	public function store(StoreUserRequest $request)
	{
		app()->setLocale($request['locale']);
		$attributes = $request->validated();
		$attributes = User::create([
			'name'     => $attributes['name'],
			'email'    => $attributes['email'],
			'password' => bcrypt($attributes['password']),
		]);
		event(new Registered($attributes));
		return response()->json(['message' => 'Registered Successfully!']);
	}

	public function verifyEmail(Request $request)
	{
		auth()->loginUsingId($request->route('id'));
		if ($request->route('id') != $request->user()->getKey())
		{
			throw new AuthorizationException();
		}
		if ($request->user()->hasVerifiedEmail())
		{
			return response()->json(['message' => 'Already verified']);
		}
		if ($request->user()->markEmailAsVerified())
		{
			event(new Verified($request->user()));
		}
		auth()->logout();
		return response()->json(['message'=>'Successfully verified!']);
	}
}
