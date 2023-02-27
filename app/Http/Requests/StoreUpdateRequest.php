<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
{
	public function rules()
	{
		if ($this['username'] === auth()->user()->name)
		{
			return [
				'password'              => ['nullable', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/', 'confirmed'],
				'password_confirmation' => ['required_if:password,not_null'],
			];
		}
		else
		{
			return [
				'password'              => ['nullable', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/', 'confirmed'],
				'password_confirmation' => ['required_if:password,not_null'],
				'username'              => ['required', 'min:3', 'max:15', 'regex:/^[a-z0-9]+$/', 'unique:users,name'],
			];
		}
	}
}
