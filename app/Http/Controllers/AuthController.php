<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;

class AuthController extends Controller
{
    public function store(StoreAuthRequest $request)
    {
        $remember = $request['remember'];
        $attributes = $request->validated();

        if (auth()->attempt($attributes, $remember)) {
            $request->session()->regenerate();
            return response()->json(['message' => 'Successfully logged in'.$remember]);
        }

        return response()->json(['error' => 'user-not-found'], 401);
    }
}
