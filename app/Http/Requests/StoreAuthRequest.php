<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthRequest extends FormRequest
{
	public function rules()
	{
		return [
			'email'    => ['required', 'email'],
			'password' => ['required', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/'],
		];
	}
}
