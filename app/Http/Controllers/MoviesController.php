<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Models\Genre;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function index()
    {
        return response()->json([['movies' => Movie::with('genres')->get()]]);
    }

    public function store(StoreMovieRequest $request)
    {
        $attributes = $request->validated();
        $thumbnail = $request->file('thumbnail');
        $thumbnailName = $thumbnail->store('thumbnails');
        $movie = Movie::create([
            'title' => [
                'en' => $attributes['title-en'],
                'ka' => $attributes['title-ka']
            ],
            'description' => [
                'en' => $attributes['description-en'],
                'ka' => $attributes['description-ka']
            ],
            'director' => [
                'en' => $attributes['director-en'],
                'ka' => $attributes['director-ka']
            ],
            'year' => Carbon::createFromDate($attributes['date'])->format('Y'),
            'budget' => $attributes['budget'],
            'thumbnail' => asset('storage/' . $thumbnailName)
        ]);

        $genres = collect($attributes['genres']);
        $genres = collect($attributes['genres']);
        $genreIds = Genre::whereIn('name', $genres)->pluck('id');
        $movie->genres()->sync($genreIds);

        return response()->json(['message' => "movie-add"]);
    }

    public function update(StoreMovieRequest $request)
    {
        $id = $request['id'];
        $attributes=$request->validated();
        $thumbnail = $request->file('thumbnail');
        $thumbnailName = $thumbnail->store('thumbnails');
        $movie = Movie::where('id', $id)->first();
        $movie->update([
            'title' => [
                'en' => $attributes['title-en'],
                'ka' => $attributes['title-ka']
            ],
            'description' => [
                'en' => $attributes['description-en'],
                'ka' => $attributes['description-ka']
            ],
            'director' => [
                'en' => $attributes['director-en'],
                'ka' => $attributes['director-ka']
            ],
            'year' => Carbon::createFromDate($attributes['date'])->format('Y'),
            'budget' => $attributes['budget'],
            'thumbnail' => asset('storage/' . $thumbnailName)
        ]);

        $movie->genres()->detach();
        $genres = collect($attributes['genres']);
        $genreIds = Genre::whereIn('name', $genres)->pluck('id');
        $movie->genres()->sync($genreIds);
        return response()->json(['message' => "movie-update"]);
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $movie = Movie::where('id', $id)->first();
        $movie->genres()->detach();
        $movie->delete();
        return response()->json(['message' => "movie-delete"]);
    }
}
