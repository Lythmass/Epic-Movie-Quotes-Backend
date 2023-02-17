<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class NewsFeedController extends Controller
{
    public function index()
    {
        return response()->json(['quotes' => Quote::with('movie')->get()]);
    }
}
