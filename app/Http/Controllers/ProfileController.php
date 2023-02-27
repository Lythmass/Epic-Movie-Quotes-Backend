<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
	public function sendUserData()
	{
		return response(['user-data' => auth()->user()->load('emails')]);
	}

	public function store(StoreUpdateRequest $request)
	{
		$userDetails = Auth::user();
		$user = User::find($userDetails->id);
		$request->validated();
		if ($request['password'] !== null)
		{
			$user->password = bcrypt($request['password']);
		}
		$user->name = $request['username'];
		$user->save();
		return response()->json(['message' => 'responses.update']);
	}
}
