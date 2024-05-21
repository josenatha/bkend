<?php

use Illuminate\Support\Facades\Route;
use laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/google-auth/redirect', function() {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-auth/callback', function() {
    $user = Socialite::driver('google')->user();
});

Route::get('/', function () {
    return view('welcome');
});
