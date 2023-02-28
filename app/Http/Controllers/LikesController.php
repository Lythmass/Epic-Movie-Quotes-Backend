<?php

namespace App\Http\Controllers;

use App\Events\Refetch;
use App\Events\SendNotification;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Quote;
use Illuminate\Http\Request;

class LikesController extends Controller
{
	public function index()
	{
		return response()->json(['likes' => Like::all()]);
	}

	public function store(Request $request)
	{
		$like = Like::create([
			'user_id'  => auth()->user()->id,
			'quote_id' => $request['quote_id'],
		]);
		$profile_picture = auth()->user()->profile_picture != null ? auth()->user()->profile_picture : '/assets/images/tlotr.png';
		$notification = Notification::create([
			'user_id'                => Quote::where('id', $request['quote_id'])->pluck('user_id')->first(),
			'author'                 => auth()->user()->name,
			'author_profile_picture' => $profile_picture,
			'is_comment'             => false,
			'is_read'                => false,
			'quote_id'               => $request['quote_id'],
		]);
		event(new SendNotification($notification));
		event(new Refetch('refetch-likes'));
		return response()->json(['message' => $like->id]);
	}

	public function destroy(Request $request)
	{
		Like::where('id', $request['id'])->delete();
		return response()->json(['message' => 'unliked']);
	}
}
