<?php

namespace App\Http\Controllers;
use App\Models\Writing;  
use Illuminate\Http\Request;

class WritingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // GET /api/writings
    public function index()
    {
        $writings = Writing::with(['author', 'comments', 'likes'])
            ->latest()
            ->get();

        return response()->json($writings);
    }

    // POST /api/writings
    public function store(Request $request)
    {
        $data = $request->validate([
            'author_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'preview' => 'nullable|string',
            'content' => 'required|string',
            'reading_time' => 'nullable|integer',
        ]);

        // Optional: auto-generate preview if not provided
        if (empty($data['preview'])) {
            $data['preview'] = Str::limit(strip_tags($data['content']), 100);
        }

        $writing = Writing::create($data);

        return response()->json($writing, 201);
    }

    // GET /api/writings/{id}
    public function show(Writing $writing)
    {
        $writing->load(['author', 'comments.replies', 'likes']);

        return response()->json($writing);
    }

    // PUT /api/writings/{id}
    public function update(Request $request, Writing $writing)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:100',
            'preview' => 'sometimes|string',
            'content' => 'sometimes|string',
            'reading_time' => 'sometimes|integer',
        ]);

        $writing->update($data);

        return response()->json($writing);
    }

    // DELETE /api/writings/{id}
    public function destroy(Writing $writing)
    {
        $writing->delete();

        return response()->json(['message' => 'Writing deleted successfully']);
    }

    public function topLiked()
    {
        // Directly sort by likes_count since it's stored in the writings table
        $writings = \App\Models\Writing::orderByDesc('likes_count')
            ->take(5)
            ->get(['id', 'title', 'preview', 'reading_time', 'likes_count', 'category']);

        return response()->json($writings);
    }

    public function personalized()
    {
        // Get the latest 2 writings
        $latest = Writing::with('author')
            ->latest()
            ->take(2)
            ->get(['id', 'title', 'category', 'reading_time', 'author_id', 'preview']);

        // Get one random writing (for continue reading)
        $random = Writing::with('author')
            ->inRandomOrder()
            ->first(['id', 'title', 'category', 'reading_time', 'author_id', 'preview']);

        // Combine them into a response
        return response()->json([
            'continue_reading' => $random,
            'latest_writings' => $latest
        ]);
    }
    public function filter(Request $request)
    {
        $query = Writing::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        if ($request->has('categories')) {
            $categories = explode(',', $request->categories);
            $query->whereIn('category', $categories);
        }

        if ($request->has('moods')) {
            $moods = explode(',', $request->moods);
            $query->whereIn('mood', $moods);
        }

        $writings = $query->latest()->get();

        return response()->json($writings);
    }


}
