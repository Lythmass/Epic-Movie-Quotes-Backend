<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotesRequest;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuotesController extends Controller
{
    public function index(Request $request)
    {
        $movieId = $request['id'];
        return response()->json(['quotes' => Quote::where('user_id', auth()->user()->id)->where('movie_id', $movieId)->get()]);
    }

    public function store(StoreQuotesRequest $request)
    {
        $attributes = $request->validated();
        $thumbnail = $request->file('thumbnail');
        $thumbnailName = $thumbnail->store('thumbnails');
        Quote::create([
            'user_id' => auth()->user()->id,
            'movie_id' => $request['id'],
            'quote' => [
                'en' => $attributes['quote-en'],
                'ka' => $attributes['quote-ka'],
            ],
            'thumbnail' => asset('storage/' . $thumbnailName)
        ]);

        return response()->json(['message' => 'quote-add']);
    }
}