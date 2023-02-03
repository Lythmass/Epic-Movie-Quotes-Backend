<?php

namespace App\Http\Controllers;

use App\Mail\VerifySecondaryEmail;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Access\AuthorizationException;

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
            $token = sha1($email);
            app()->setLocale($request['locale']);
            Mail::to($email)->send(new VerifySecondaryEmail($userId, $email, $token));
            return response()->json(['message' => 'Email added successfully!']);
        }
    }

    public function verifyEmail(Request $request)
    {
        auth()->loginUsingId($request->route('id'));
        $token = $request->route('hash');
        $email = $request->route('email');
        $user = auth()->user()->emails->where('email', $email)->first();
        if ($user->email_verified_at !== null) {
            return response()->json(['message' => 'Your email has been verified already']);
        }
        if (sha1($email) === $token) {
            $user->email_verified_at = now();
            $user->save();
            return response()->json(['message' => 'Your email was verified successfully!']);
        } else {
            throw new AuthorizationException();
        }
    }

    public function destroy(Request $request)
    {
        $email = $request['email'];
        Email::where('email', $email)->delete();
        return response()->json(['message' => 'Successfully removed email.']);
    }
}
