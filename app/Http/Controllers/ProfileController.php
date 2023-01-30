<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function sendUserData()
    {
        return response(['user-data' => auth()->user()]);
    }

    public function store(Request $request)
    {
        $userDetails = Auth::user();
        $user = User::find($userDetails->id);
        if ($user->name === $request['username'] && strlen($request['password']) < 1) {
            return response()->json(['message' => 'No changes were made.']);
        }
        if ($user->name === $request['username'] && strlen($request['password']) >= 1) {
            $request->validate([
                'password' => ['min:8', 'max:15', 'regex:/^[a-z0-9]+$/', 'confirmed'],
                'password_confirmation' => ['required']
            ]);
            $user->password = bcrypt($request['password']);
            $user->save();
            return response()->json(['message' => 'Your password was changed successfully!']);
        }
        if ($user->name !== $request['username'] && strlen($request['password']) < 1) {
            $request->validate(['username' =>['required', 'min:3', 'max:15', 'regex:/^[a-z0-9]+$/', 'unique:users,name']]);
            $user->name = $request['username'];
            $user->save();
            return response()->json(['message' => 'Your username was changed successfully!']);
        }
        if ($user->name !== $request['username'] && strlen($request['password']) >= 1) {
            $request->validate([
                'password' => ['min:8', 'max:15', 'regex:/^[a-z0-9]+$/', 'confirmed'],
                'password_confirmation' => ['required'],
                'username' =>['required', 'min:3', 'max:15', 'regex:/^[a-z0-9]+$/', 'unique:users,name']
            ]);
            $user->password = bcrypt($request['password']);
            $user->name = $request['username'];
            $user->save();
            return response()->json(['message' => 'Your username and password was changed successfully!']);
        }

        return response()->json(['message' => 'Successfully changed data!']);
    }
}
