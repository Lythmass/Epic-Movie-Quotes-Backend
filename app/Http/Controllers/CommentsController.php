<?php

namespace App\Http\Controllers;

use App\Events\Refetch;
use App\Events\SendNotification;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Quote;

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
			'user_id'  => auth()->user()->id,
			'quote_id' => $attributes['quote_id'],
			'comment'  => $attributes['comment'],
		]);
		$profile_picture = auth()->user()->profile_picture != null ? auth()->user()->profile_picture : '/assets/images/tlotr.png';
		$notification = Notification::create([
			'user_id'                => Quote::where('id', $request['quote_id'])->pluck('user_id')->first(),
			'author'                 => auth()->user()->name,
			'author_profile_picture' => $profile_picture,
			'is_comment'             => true,
			'is_read'                => false,
		]);
		event(new SendNotification($notification));
		event(new Refetch('refetch-comments'));
		return response()->json(['message' => 'comment-add']);
	}
}
