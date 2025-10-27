<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Writing;
use App\Models\Comment;

class StatsController extends Controller
{
    public function index()
    {
        // ✅ Total writings (acts as total readings)
        $totalReadings = Writing::count();

        // ✅ Total minutes read — from `reading_time` column
        $totalMinutes = Writing::sum('reading_time');

        // ✅ Total favorites/likes — from writings + comments
        $favoriteCount = Writing::sum('likes_count') + Comment::sum('likes_count');

        // ✅ Total comments
        $commentsCount = Comment::count();

        return response()->json([
            'totalReadings' => $totalReadings,
            'totalMinutes' => $totalMinutes,
            'favoriteCount' => $favoriteCount,
            'commentsCount' => $commentsCount,
        ]);
    }
}
