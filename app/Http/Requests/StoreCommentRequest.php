<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
	public function rules()
	{
		return [
			'comment'  => 'required',
			'quote_id' => 'required',
		];
	}
}
