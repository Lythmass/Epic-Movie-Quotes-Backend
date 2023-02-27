<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
	public function rules()
	{
		return [
			'description-en' => 'required',
			'description-ka' => 'required',
			'director-en'    => 'required',
			'director-ka'    => 'required',
			'title-en'       => ['required'],
			'title-ka'       => 'required',
			'genres'         => 'required',
			'thumbnail'      => 'required',
			'budget'         => 'required',
			'date'           => 'required',
			'budget'         => ['required', 'numeric'],
		];
	}
}
