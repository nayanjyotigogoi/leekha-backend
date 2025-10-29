<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WritingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReadersWallController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// To get logged-in user details
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/reading-stats', [StatsController::class, 'index']);
Route::get('/writings', [WritingController::class, 'filter']);

Route::get('media', [MediaController::class, 'index']);
Route::post('media', [MediaController::class, 'store']);
Route::delete('media/{media}', [MediaController::class, 'destroy']);


// Route::apiResource('categories', CategoryController::class);
// Route::get('/categories', [CategoryController::class, 'index']);
// Route::get('/categories/{slug}', [CategoryController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);


Route::get('readers-wall', [ReadersWallController::class, 'index']);
Route::post('readers-wall', [ReadersWallController::class, 'store']);
Route::delete('readers-wall/{readersWall}', [ReadersWallController::class, 'destroy']);


Route::post('likes', [LikeController::class, 'store']);
Route::delete('likes', [LikeController::class, 'destroy']);
Route::get('likes/{target_type}/{target_id}', [LikeController::class, 'count']);
Route::get('/writings/top-liked', [WritingController::class, 'topLiked']);

Route::get('/personalized-readings', [WritingController::class, 'personalized']);



// Route::get('/comments/{writing_id}', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store']);
Route::put('/comments/{id}', [CommentController::class, 'update']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

Route::get('/comments/{writing_id}', [CommentController::class, 'index']);
// Route::post('/comments', [CommentController::class, 'store']);

// List comments for a writing
Route::get('comments/{writing_id}', [CommentController::class, 'index']);

// Standard CRUD
Route::apiResource('comments', CommentController::class)->except(['index']);

Route::apiResource('writings', WritingController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
