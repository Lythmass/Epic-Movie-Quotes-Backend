<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index()
    {
        return response()->json(['comments' => Comment::with('user')->latest()->get()]);
    }

    public function store(StoreCommentRequest $request)
    {
        $attributes = $request->validated();
        Comment::create([
            'user_id' => auth()->user()->id,
            'quote_id' => $attributes['quote_id'],
            'comment' => $attributes['comment']
        ]);
        return response()->json(['message' => 'comment-add']);
    }
}
