<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'blogger_id' => 'required|exists:bloggers,id',
        ]);

        $userId = Auth::id();
        $bloggerId = $request->blogger_id;

        $existingLike = Like::where('blogger_id', $bloggerId)
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $status = 'unliked';
        } else {
            Like::create([
                'user_id' => $userId,
                'blogger_id' => $bloggerId
            ]);
            $status = 'liked';
        }
        $likeCount = Like::where('blogger_id', $bloggerId)->count();

        return response()->json(['status' => $status, 'count' => $likeCount]);
    }
}
