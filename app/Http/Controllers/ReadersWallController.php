<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReadersWall; 

class ReadersWallController extends Controller
{
    // GET /api/readers-wall → list all posts
    public function index()
    {
        $posts = ReadersWall::latest()->get();
        return response()->json($posts);
    }

    // POST /api/readers-wall → create a post
    public function store(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|string|max:280',
            'color' => 'nullable|string|size:7', // hex color like #FFAA33
        ]);

        if (empty($data['color'])) {
            $data['color'] = '#FFFFFF'; // default color
        }

        $post = ReadersWall::create($data);

        return response()->json($post, 201);
    }

    // DELETE /api/readers-wall/{id} → delete a post
    public function destroy(ReadersWall $readersWall)
    {
        $readersWall->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
