<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserFrequentResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $usersList = User::withWhereHas('userFrequents', function ($q) {
            $q->with(['fromStation', 'toStation']);
            $q->groupBy(['user_id']);
            $q->havingRaw('max(count)');
        })->get();
            
        return response()->json(UserFrequentResource::collection($usersList));
    }
}
