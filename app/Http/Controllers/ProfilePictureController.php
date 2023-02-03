<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilePictureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['image' => ['required', 'image']]);
        $profilePicture = $request->file('image');
        $user = User::where('id', auth()->user()->id)->first();
        $imageName = $profilePicture->store('profile_pictures');
        $user->profile_picture = asset('storage/' . $imageName);
        $user->save();
    }
}
