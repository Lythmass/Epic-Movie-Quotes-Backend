<?php

namespace App\Http\Controllers;

use App\Mail\VerifySecondaryEmail;
use App\Models\Email;
use App\Models\User;
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
		if ($emailExists)
		{
			return response(['message' => 'responses.already-registered'], 401);
		}
		else
		{
			Email::create([
				'user_id' => $userId,
				'email'   => $email,
			]);
			$token = sha1($email);
			app()->setLocale($request['locale']);
			Mail::to($email)->send(new VerifySecondaryEmail($userId, $email, $token));
			return response()->json(['message' => 'responses.email-added']);
		}
	}

	public function verifyEmail(Request $request)
	{
		auth()->loginUsingId($request->route('id'));
		$token = $request->route('hash');
		$email = $request->route('email');
		$user = auth()->user()->emails->where('email', $email)->first();
		if ($user->email_verified_at !== null)
		{
			return response()->json(['message' => 'responses.already-verified']);
		}
		if (sha1($email) === $token)
		{
			$user->email_verified_at = now();
			$user->save();
			return response()->json(['message' => 'responses.verified-success']);
		}
		else
		{
			throw new AuthorizationException();
		}
	}

	public function update(Request $request)
	{
		$user = User::where('id', auth()->user()->id)->first();
		$email = $request['email'];
		$secondaryEmails = $user->emails->where('email', $email)->first();
		$verificationDate = $secondaryEmails->email_verified_at;
		$secondaryEmails->email = $user->email;
		$secondaryEmails->email_verified_at = $user->email_verified_at;
		$secondaryEmails->save();
		$user->email = $email;
		$user->email_verified_at = $verificationDate;
		$user->save();
		return response()->json(['message' => 'responses.change-primary']);
	}

	public function destroy(Request $request)
	{
		$email = $request['email'];
		Email::where('email', $email)->delete();
		return response()->json(['message' => 'responses.remove-email']);
	}
}
