<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'min:3', 'max:15', 'regex:/^[a-z0-9]+$/', 'unique:users,name'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/', 'confirmed'],
            'password_confirmation' => ['required', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/']
        ];
    }
}
