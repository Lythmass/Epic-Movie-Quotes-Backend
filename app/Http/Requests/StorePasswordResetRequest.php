<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePasswordResetRequest extends FormRequest
{
	public function rules()
	{
		return [
			'token'                 => ['required'],
			'email'                 => ['required', 'email'],
			'password'              => ['required', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/', 'confirmed'],
			'password_confirmation' => ['required', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/'],
		];
	}
}
