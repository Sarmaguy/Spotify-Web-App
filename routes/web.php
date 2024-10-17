<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpotifyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/example', function () {
    return view('example');
});

Route::get('/spotify/login', [SpotifyController::class, 'login'])->name('spotify.login');

Route::get('/spotify/callback', [SpotifyController::class, 'callback'])->name('spotify.callback');
