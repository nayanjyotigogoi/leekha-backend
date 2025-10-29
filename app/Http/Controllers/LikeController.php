<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like; 
class LikeController extends Controller
{
    // POST /api/likes → add a like
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id', // optional for guests
            'target_type' => 'required|string|in:App\\Models\\Writing,App\\Models\\Comment',
            'target_id' => 'required|integer',
        ]);

        // Prevent duplicate likes for logged-in users
        if (isset($data['user_id'])) {
            $exists = Like::where([
                'user_id' => $data['user_id'],
                'target_type' => $data['target_type'],
                'target_id' => $data['target_id'],
            ])->first();

            if ($exists) {
                return response()->json(['message' => 'Already liked'], 409);
            }
        }

        $like = Like::create($data);

        return response()->json($like, 201);
    }

    // DELETE /api/likes → remove a like
    public function destroy(Request $request)
    {
        $request->merge(json_decode($request->getContent(), true) ?? []);

        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'target_type' => 'required|string|in:App\\Models\\Writing,App\\Models\\Comment',
            'target_id' => 'required|integer',
        ]);

        $likeQuery = Like::where([
            'target_type' => $data['target_type'],
            'target_id' => $data['target_id'],
        ]);

        if (isset($data['user_id'])) {
            $likeQuery->where('user_id', $data['user_id']);
        }

        $like = $likeQuery->first();

        if (!$like) {
            return response()->json(['message' => 'Like not found'], 404);
        }

        $like->delete();

        return response()->json(['message' => 'Like removed successfully']);
    }

    // GET /api/likes/{target_type}/{target_id} → count likes
    public function count($target_type, $target_id)
    {
        $count = Like::where('target_type', $target_type)
                     ->where('target_id', $target_id)
                     ->count();

        return response()->json(['likes_count' => $count]);
    }
}
