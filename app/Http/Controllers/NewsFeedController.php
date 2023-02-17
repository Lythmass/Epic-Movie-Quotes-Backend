<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class NewsFeedController extends Controller
{
    public function getNumberOfQuotes()
    {
        return response()->json(['length' => Quote::all()->count()]);
    }

    public function index(Request $request)
    {
        $startRange = $request['startRange'];
        $endRange = $startRange + 2;
        $quotes = Quote::with('movie')->latest()->skip($startRange)->take($endRange)->get();
        return response()->json(['quotes' => $quotes]);
    }
}
