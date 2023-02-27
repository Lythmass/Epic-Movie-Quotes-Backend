<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class NewsFeedController extends Controller
{
	public function getNumberOfQuotes()
	{
		return response()->json(['length' => Quote::all()->count()]);
	}

	public function index(Request $request)
	{
		$searchType = $request['search_type'];
		$locale = $request['locale'];
		if ($searchType == null)
		{
			$startRange = $request['startRange'];
			$quotes = Quote::with(['movie', 'comments.user', 'user'])->latest()->skip($startRange)->take(2)->get();
			return response()->json(['quotes' => $quotes]);
		}
		if ($searchType == '@')
		{
			$search = $request['search'];
			$quotes = Quote::with(['movie', 'comments.user', 'user'])->latest()->whereHas('movie', function (Builder $query) use ($search, $locale) {
				$query->where('title->' . $locale, 'like', $search . '%');
			})->get();
			return response()->json(['quotes' => $quotes]);
		}
		if ($searchType == '#')
		{
			$search = $request['search'];
			$quotes = Quote::with(['movie', 'comments.user', 'user'])->latest()->where('quote->' . $locale, 'like', $search . '%')->get();
			return response()->json(['quotes' => $quotes]);
		}
	}

	public function store(StorePostRequest $request)
	{
		$attributes = $request->validated();
		$thumbnail = $request->file('thumbnail');
		$thumbnailName = $thumbnail->store('thumbnails');
		Quote::create([
			'user_id'  => auth()->user()->id,
			'movie_id' => $request['movie'],
			'quote'    => [
				'en' => $attributes['quote-en'],
				'ka' => $attributes['quote-ka'],
			],
			'thumbnail' => asset('storage/' . $thumbnailName),
		]);

		return response()->json(['message' => 'quote-add']);
	}
}
