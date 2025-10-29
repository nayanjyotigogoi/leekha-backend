<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    // GET /api/comments/{writing_id}
    public function index($writing_id)
    {
        $comments = Comment::with('replies', 'likes')
            ->where('writing_id', $writing_id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return response()->json($comments);
    }

    // POST /api/comments
    public function store(Request $request)
    {
        $user = $request->user(); // ← get logged-in user if Sanctum session exists

        $data = $request->validate([
            'writing_id' => 'required|exists:writings,id',
            'parent_id' => 'nullable|exists:comments,id',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:100',
            'author_email' => 'nullable|email|max:150',
        ]);

        // 👇 if user is logged in, override name/email
        if ($user) {
            $data['user_id'] = $user->id;
            $data['author_name'] = $user->name;
            $data['author_email'] = $user->email;
        } else {
            // guests must provide a name
            if (empty($data['author_name'])) {
                return response()->json(['message' => 'Author name is required for guests'], 422);
            }
        }

        $comment = Comment::create($data);

        return response()->json($comment, 201);
    }

    // PUT /api/comments/{id}
    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($data);

        return response()->json($comment);
    }

    // DELETE /api/comments/{id}
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
