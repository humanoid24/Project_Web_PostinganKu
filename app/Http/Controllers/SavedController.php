<?php

namespace App\Http\Controllers;

use App\Models\Saved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'blogger_id' => 'required|exists:bloggers,id'
        ]);

        $userId = Auth::id();
        $bloggerId = $request->blogger_id;

        $existingSaved = Saved::where('blogger_id', $bloggerId)
            ->where('user_id', $userId)
            ->first();

        if ($existingSaved) {
            $existingSaved->delete();
            $status = 'unsaved';
        } else {
            Saved::create([
                'user_id' => $userId,
                'blogger_id' => $bloggerId
            ]);
            $status = 'saved';
        }
        $savedCount = Saved::where('blogger_id', $bloggerId)->count();

        return response()->json(['status' => $status, 'count' => $savedCount]);
    }

    public function show()
    {
        $userId = Auth::id();

        $savedPosts = Saved::with(['blogger.user'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('halaman.postingantersimpan', compact('savedPosts'));
    }
}
