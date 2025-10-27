<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media; 
class MediaController extends Controller
{
 // GET /api/media → list all media
    public function index()
    {
        $media = Media::latest()->get();
        return response()->json($media);
    }

    // POST /api/media → upload new media
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:image,sound,sticker',
            'file' => 'required|file|max:10240', // max 10MB
            'alt_text' => 'nullable|string|max:255',
            'metadata' => 'nullable|array',
        ]);

        // Save file to storage/app/public/media
        $path = $request->file('file')->store('media', 'public');

        $media = Media::create([
            'type' => $data['type'],
            'path' => $path,
            'alt_text' => $data['alt_text'] ?? null,
            'metadata' => $data['metadata'] ?? null,
        ]);

        return response()->json($media, 201);
    }

    // DELETE /api/media/{id} → delete media
    public function destroy(Media $media)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }

        $media->delete();

        return response()->json(['message' => 'Media deleted successfully']);
    }
}
