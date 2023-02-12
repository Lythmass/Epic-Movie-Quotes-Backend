<?php

namespace App\Http\Controllers;

use App\Models\Genre;

class GenresController extends Controller
{
    public function index()
    {
        return response()->json(['genres' => Genre::all(['name'])]);
    }
}
