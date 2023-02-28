<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotesRequest extends FormRequest
{
	public function rules()
	{
		return [
			'quote-en'  => ['required'],
			'quote-ka'  => ['required'],
		];
	}
}
