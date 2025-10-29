<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


use Illuminate\Support\Facades\Response;

Route::get('/sitemap.xml', function () {
    $urls = [
        url('/'),
        url('/admin/login'),
        // You can later add dynamic content pages here:
        // e.g., url('/writings'), url('/about'), etc.
    ];

    $xml = view('sitemap', compact('urls'))->render();
    return Response::make($xml, 200)->header('Content-Type', 'application/xml');
});
