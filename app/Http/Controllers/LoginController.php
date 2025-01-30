<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $response = Http::asForm()->post('host.docker.internal:8008/oauth/token', [
            'grant_type' => 'password',
            'username' => $request->validated()['email'],
            'password' => $request->validated()['password'],
            'scope' => '*',
            'client_id' => '9e17d889-057a-4403-bdd5-2c2b6c1d7acb',
            'client_secret' => 'S6sdaD6J0n6JY795HwUPZWz2WeZVLoTXvaOE6Pee',
        ]);
        return $response->json();
    }
}
