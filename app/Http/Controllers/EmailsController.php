<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailsController extends Controller
{
    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        $request->validate(['email' => ['required', 'email']]);
        $email = $request['email'];
        $emailExists = Email::where('email', $email)->exists();
        if ($emailExists) {
            return response(['message' => 'Email is registered already!'], 401);
        } else {
            Email::create([
                'user_id' => $userId,
                'email' => $email
            ]);
            return response()->json(['message' => 'Email added successfully!']);
        }
    }
}
