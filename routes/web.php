<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/login', function(){
    return view('auth.login');
})->name('login');
Route::post('/login', function(Request $request) {
    $user = User::where('email', $request->email)->first();
    dd($user);
    Auth::login($user);
    return redirect('/');
});
Route::get('/auth/callback/{id}', function ($id){
    $user = User::firstOrCreate(
        ['third_party_id' => $id], 
        [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'password', // password
        ]
    );
    Auth::login($user);
    return redirect('/');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::post('/logout', function () {
        Session::flush();
        Auth::logout();
        return redirect('login');
    })->name('logout');
});